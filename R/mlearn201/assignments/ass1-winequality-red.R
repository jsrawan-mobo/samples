# do stepwise regression on file winequality-red.csv
#
#
#
# Do step regression on 
#
# To evaluate the fit: 
# Should understand variability in the output
# Estimated error on new data
#
# Cross Validation assume no distribution, blindly do all the combination.
#
#
# S-1 Read the file in and verify the follow
#
# 1599 observations, or 11 attributes
# avg/std/min/max/rms of all 11 attributes
#

library(ggplot2)
rm(list=ls())


##############################FUNCTIONS#####################################
stats <- function(x) {
    ans <- boxplot.stats(x)
    data.frame(ymin = ans$conf[1], ymax = ans$conf[2])
}

vgrid <- function(x,y) {
    viewport(layout.pos.row = x, layout.pos.col = y)
}

ggboxplotcustom <- function (data_set_frame) {

    nCol <- ncol(data)
    nCol = 1
    #pushViewport(viewport(layout=grid.layout(1,nCol)))
    q = list();
    for(iCol in 1:nCol){
    
         q[[1]] <- ggplot(data=data_set, mapping = aes(names, data_set[,iCol] )) + 
         #    q[[1]] <- ggplot(data=data_set, aes(x=name, y=data_set[,iCol] ) ) +
            geom_boxplot(notch = TRUE, notchwidth = 0.5) +
            stat_summary(fun.data = stats, geom = "linerange", colour = "skyblue", size = 5)
        #q[[iCol]] = 
        #    p            
    }
    return (q)
}

# then the description of the plot is natural
ggsimpleboxplot <- function (data_set) {
    
    data_stats <- data.frame(
        mean = mean(data_set),
        std = sd(data_set),
        max = apply(data_set,2, max),
        min = apply(data_set,2,min)
    )    
     qplot(names, mean, data = data_stats) +
        geom_linerange(aes(ymin = mean - std, ymax = mean + std)) +
        geom_boxplot(notch = TRUE, notchwidth = 0.5)
    
}

basesimpleboxplot <- function (data_set) {
    
    data_stats <- data.frame(
        mean = mean(data_set),
        std = sd(data_set),
        max = apply(data_set,2, max),
        min = apply(data_set,2,min)
    )    
    
    #barplot (wine_raw_avg, ylab = "avg", xlab = "",  las=2)

    #boxplot(fixed.acidity~quality,data=wine_raw, main="Fixed.Acidity by Quality",
    #   xlab="Quality", ylab="Fixed.Acidity") 

}


echo <- function(x) { 
    print(x)
}



stepwise_fw_regression <- function (data_set, folds) {
    
    tCol = ncol(data_set)
    X = data_set[,1:(tCol-1)]
    Y = data_set[,tCol]
    nCol = ncol(X)
    Index <- 1:nrow(X)
    colIndex <- 1:nCol
    seBest <- 1000000.0 #set really big sum of square error
    seArray <- rep(0.0, nCol-1)
    Xtemp <- X[,1]
    nxval <- folds # 10 fold, about 160 obs per fold.
    
    
    ## for each column, computer the regression
    ## %% is modulus
    ## Ytemp ~ Xtemptmp, is Y the output predicted by the X
    ## This performs the stepwise for each column
    ## fit the linear mod of Y for 10 different data sets
    for(iCol in 1:nCol){
        Xcurrent <- X[,iCol]
        se <- 0.0
    	for(ixval in 1:nxval){
    		Iout <- which(Index%%nxval==(ixval-1))        
            #cat ("Number of Samples", length(Iout) , '\thello\n' )
            
            ##The negative is the test set.  The positive is the current training set
     		Xtrain <- Xcurrent[-Iout]
    		Xtext <- Xcurrent[Iout]
    		Ytrain <- Y[-Iout]
    		Ytest <- Y[Iout]
            
            # Linear model returns coefficients
            # y = mx+b.  The intercept, b is the first coefficient, and m is second cofficient.
            # Use the cofficients to get the estimate Y.
            # So we basically just get a line back.
    		linMod <- lm(Ytrain ~ Xtrain)	
    		v <- as.array(linMod$coefficients)
    		yHat <- rep(0.0,length(Xtext))  
    		for(i in 1:length(Xtext)) {
    			yHat[i] <- v[1] + Xtext[i]*v[2]		
    		}
    		dY <- yHat -Ytest
    		seTemp <- (1/length(Xtext))*sum(dY*dY)
            cat ("StandardError for", names(wine_raw)[iCol], ' error'  ,  seTemp , '\thello\n' )
    		se <- se + seTemp/nxval		
    	}
    	#print(iCol + "--" + se)
    	if(se < seBest) {
    		seBest <- se
    		iColBest <- iCol
    	}
    }
    stats_frame = data.frame( seBest = seBest, 
                               iColBest = iColBest)
    return (stats_frame);
    
}
################################MAIN######################################3333


wine_raw <- read.table(file="winequality-red.txt",  sep=';', header=T)
data_set_frame <- data.frame(
                        data_set = wine_raw,
                        xValue = 1:1599
                         )

# Doesn't work in function due to AES problems
#ggsimpleboxplot(data_set)
#q = ggboxplotcustom(data_set_frame)
#nCol = ncol(wine_raw)
#pushViewport(viewport(layout=grid.layout(1,nCol)))
#name = "hello"
#iCol = 1
#print (q);
#print(q[[1]], vp=vgrid(1,1))

#nCol = ncol(wine_raw)
#for(iCol in 1:nCol){
#     print(p[iCol], vp=vgrid(1,iCol))
# }


#
# The box plot gives us the distribution
# the box lower, middle, upper gives the 25%, mean, 75%
# the black line gives you the 10%, 90%.  The dots are out of range.
# Doesn't handle floating point values

nCol = ncol(wine_raw)
pushViewport(viewport(layout=grid.layout(1,nCol)))
for(iCol in 1:nCol){

    name = names(wine_raw)[iCol]
    print(name)
    p <- ggplot(data=wine_raw, aes(name, wine_raw[,iCol] )) + 
        geom_boxplot(notch = TRUE, notchwidth = 0.5) +
        stat_summary(fun.data = stats, geom = "linerange", colour = "skyblue", size = 5)
    q = list(p)
    print(q[[1]], vp=vgrid(1,iCol))
}

#
# Dump this to a png
#
#
png("WineQuality-BoxPlot.png", 4000,1500,res=300)
grid.newpage()
for(iCol in 1:nCol){
    print( p[iCol],vp=vgrid(1,nCol))
}
dev.off()

 

#with (wine_stats_frame, {
#    plot (wine_raw_avg.Names, wine_raw_avg)
#})


#
# 1. Stepwise forward regression with 10 fold cross-validation
# i.e. take each column, and do a 10 fold on it.
# Average the error for each fold
# At the end pick the parameter with smallest error.
# see ESLII pg 76 and Prostate.R
#
# Note the cross fold validation is over the samples, while the
# stepwise is the one that picks the data.
#


##1. Setup variables.  Calculate stepwise error as each column is added
## Start with first column

se_stats = stepwise_fw_regression(wine_raw, 10)

tCol = ncol(wine_raw)
X = wine_raw[,1:(tCol-1)]
Y = wine_raw[,tCol]
nCol = ncol(X)
Index <- 1:nrow(X)
colIndex <- 1:nCol
seBest <- 1000000.0 #set really big sum of square error
seArray <- rep(0.0, nCol-1)
Xtemp <- X[,1]
nxval <- 10 # 10 fold, about 160 obs per fold.


## for each column, computer the regression
## %% is modulus
## Ytemp ~ Xtemptmp, is Y the output predicted by the X
## This performs the stepwise for each column
## fit the linear mod of Y for 10 different data sets
for(iCol in 1:nCol){
    Xcurrent <- X[,iCol]
	se <- 0.0
	for(ixval in 1:nxval){
		Iout <- which(Index%%nxval==(ixval-1))        
        #cat ("Number of Samples", length(Iout) , '\thello\n' )
        
        ##The negative is the test set.  The positive is the current training set
 		Xtrain <- Xcurrent[-Iout]
		Xtext <- Xcurrent[Iout]
		Ytrain <- Y[-Iout]
		Ytest <- Y[Iout]
        
        # Linear model returns coefficients
        # y = mx+b.  The intercept, b is the first coefficient, and m is second cofficient.
        # Use the cofficients to get the estimate Y.
        # So we basically just get a line back.
		linMod <- lm(Ytrain ~ Xtrain)	
		v <- as.array(linMod$coefficients)
		yHat <- rep(0.0,length(Xtext))  
		for(i in 1:length(Xtext)) {
			yHat[i] <- v[1] + Xtext[i]*v[2]		
		}
		dY <- yHat -Ytest
		seTemp <- (1/length(Xtext))*sum(dY*dY)
        cat ("StandardError for", names(wine_raw)[iCol], ' error'  ,  seTemp , '\thello\n' )
		se <- se + seTemp/nxval		
	}
	#print(iCol + "--" + se)
	if(se < seBest) {
		seBest <- se
		iColBest <- iCol
	}
}
 

seArray[1] <- seBest
I <- iColBest


#run through the same calculation for the next 10 variables
#skip past the first column
for(iStep in 1:nCol){
    colSelection <- colIndex[-I]
	seBest <- 1000000
	for(iTry in 1:length(colSelection)){
		iCols <- c(I,colSelection[iTry])
		Xcurrent <- as.matrix(X[,iCols])
		se <- 0.0
		for(ixval in 1:nxval){
			Iout <- which(Index%%nxval==(ixval-1))
			Xtrain <- Xcurrent[-Iout,]
			Xnew <- Xcurrent[Iout,]
			Ytrain <- Y[-Iout]
			Ynew <- Y[Iout]
			linMod <- lm(Ytrain ~ Xtrain)	
			
			v <- as.array(linMod$coefficients)
			isize <- length(v) - 1
			yHat <- rep(0.0,nrow(Xnew))
			for(i in 1:nrow(Xnew)){
				yHat[i] <- v[1]
				for(j in 1:isize){
					yHat[i] <- yHat[i] + Xnew[i,j]*v[j+1]
				}				
			}
			dY <- yHat - Ynew
			seTemp <- ((1/nrow(Xnew))*sum(dY*dY))
			se <- se + seTemp/nxval		
		}
		#print(se)
		if(se<seBest){
			seBest <- se
			iBest <- colSelection[iTry]
		}		
	}
	I <- c(I,iBest)
	print(I)
	seArray[iStep + 1] <- seBest	
}
plot(seArray)
points(sqrt(seArray), pch=".", cex=3, col=2)

# 2. Stepwise backwards regression



# 3.  All subsets



# 4. Use lars to do lars and lasso regression.


#5.  Create charts
