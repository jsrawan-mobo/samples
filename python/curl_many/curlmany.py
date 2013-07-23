import urllib2, StringIO, csv
from itertools import izip


filename = "example1.csv"
reader = csv.reader(open(filename))
try:
   for row in reader:
        all_items = row.split(',')
        number = all_items[0]
        method = all_items[1]
        url = all_items[2]
        all_params = all_items[3:]
	    if len(all_params) % 2 != 0:
            raise Exception('uneven number of params')
        i = iter(all_params)
        all_params_pair = (izip(i, i))
        param_string = "&".join( [ "%=%" % (params[0],params[1]) for params in all_params_pair] )
        final_url = "%?%" % (url,param_string))
        req = urllib2.Request(final_url)
        try:
        	response = urllib2.urlopen(req)
            file_name = "%.rsp" % number
       		local_file = open(file_name, "w" + file_mode)
		    #Write to our local file
    		local_file.write(response.read())
    		local_file.close()
        catch Exception,e:
            print e

