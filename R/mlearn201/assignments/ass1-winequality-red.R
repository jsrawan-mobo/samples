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

ggboxplotcustom <- function (data_set, fun) {

   
    nCol <- ncol(data_set)
    #nCol = 1
    pushViewport(viewport(layout=grid.layout(1,nCol)))
    q = list();
    for(iCol in 1:nCol){
    
        name = names(data_set)[iCol]
        print(name)
        p <- ggplot(data=data_set, aes(name, data_set[,iCol] )) + 
            geom_boxplot(notch = TRUE, notchwidth = 0.5) +
            stat_summary(fun.data = stats, geom = "linerange", colour = "skyblue", size = 5)
        q[[iCol]] = p            
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

################################MAIN######################################3333


wine_raw <- read.table(file="winequality-red.txt",  sep=';', header=T)
#ggsimpleboxplot(data_set)
data_set <- wine_raw
q = ggboxplotcustom(data_set, stats)
pushViewport(viewport(layout=grid.layout(1,nCol)))

#nCol = ncol(wine_raw)
print(q[[1]], vp=vgrid(1,1))


# 
# for(iCol in 1:nCol){
#     print(p[iCol], vp=vgrid(1,iCol))
# }


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





png("WineQuality-BoxPlot.png",4000,1500,res=300)
grid.newpage()
for(iCol in 1:nCol){
    print( p[iCol],vp=v(1,nCol))
}
dev.off()

 

#with (wine_stats_frame, {
#    plot (wine_raw_avg.Names, wine_raw_avg)
#})


#
# 1. Stepwise forward regression with 10 fold cross-validation
# take the each step and try to add a column
# I.e. take 9 attribues and train them.  Test again the remaining 2 
# see ESLII pg 76 and Prostate.R
#
# Note the cross fold validation is over the samples, while the
# stepwise is the one that picks the data.
#


##1. Setup variables.  Calculate stepwise error as each column is added
## Start with first column
nCol = ncol(wine_raw)
Index <- 1:nrow(wine_raw)
colIndex <- 1:nCol
seBest <- 1000000.0 
seArray <- rep(0.0, nCol-1)
Xtemp <- wine_raw[,1]
nxval <- 10

## for each column, computer the regression
## %% is modulus
## Ytemp ~ Xtemptmp, is Y the output predicted by the X
for(iTry in 1:nCol){
    Xtemp <- wine_raw[,iTry]
	se <- 0.0
	for(ixval in 1:nxval){
		Iout <- which(Index%%nxval==(ixval-1))
		XtempTemp <- Xtemp[-Iout]
		Xnew <- Xtemp[Iout]
		Ytemp <- Y[-Iout]
		Ynew <- Y[Iout]
		linMod <- lm(Ytemp ~ XtempTemp)	
		v <- as.array(linMod$coefficients)
		yHat <- rep(0.0,length(Xnew))
		for(i in 1:length(Xnew)){
			yHat[i] <- v[1] + Xnew[i]*v[2]		
		}
		dY <- yHat -Ynew
		seTemp <- (1/length(Xnew))*sum(dY*dY)
		se <- se + seTemp/nxval		
	}
	#print(se)
	if(se<seBest){
		seBest <- se
		iBest <- iTry
	}
}

#run through the same calculation for the next 6 variables
for(iStep in 1:6){
    colSelection <- colIndex[-I]
	seBest <- 1000000
	for(iTry in 1:length(colSelection)){
		iCols <- c(I,colSelection[iTry])
		Xtemp <- as.matrix(X[,iCols])
		se <- 0.0
		for(ixval in 1:nxval){
			Iout <- which(Index%%nxval==(ixval-1))
			XtempTemp <- Xtemp[-Iout,]
			Xnew <- Xtemp[Iout,]
			Ytemp <- Y[-Iout]
			Ynew <- Y[Iout]
			linMod <- lm(Ytemp ~ XtempTemp)	
			
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
points(sqrt(seArray), pch=".", cex=3, col=2)

# 2. Stepwise backwards regression



# 3.  All subsets



# 4. Use lars to do lars and lasso regression.


#5.  Create charts
