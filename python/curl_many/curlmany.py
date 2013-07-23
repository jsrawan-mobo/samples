import urllib2, StringIO, csv
from itertools import izip


filename = "example1.csv"
reader = csv.reader(open(filename), )
next(reader, None)  # skip the headers
for all_items in reader:
    number = all_items[0]
    method = all_items[1]
    url = all_items[2]
    all_params = all_items[3:]
    if len(all_params) % 2 != 0:
        raise Exception('uneven number of params')
    i = iter(all_params)
    all_params_pair = list(izip(i, i))
    #print all_params_pair
    param_string = "&".join( [ (param[0] + "=" +param[1]) for param in all_params_pair] )
    final_url = url + "?" + param_string
    print final_url
    req = urllib2.Request(final_url)
    try:
        response = urllib2.urlopen(req)
        file_name =  number + ".rsp"
        local_file = open(file_name, "w")
	    #Write to our local file
        local_file.write(response.read())
        local_file.close()
    except Exception,e:
        print e

