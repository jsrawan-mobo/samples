from optparse import OptionParser

def create_original(r):

    array_original = [True for x in range(0,r-1)]
    return array_original

def apply_function(array_original, a, b, c, r, k):

    m_old = a % r
    array_original[m_old] = False
    for i in range (1, k):
        m_new = (b * m_old + c) % r
        if array_original[m_new]:
            array_original[m_new] = False
            m_old = m_new
        else:
            break #optimization, we will repeat for ever, no point of continuing (i think, just the number is sufficient.


def return_min_integer_list(array_original, k, n):


    k_iter = k
    i = 0
    the_list = []
    for i,v in enumerate(array_original):
        if v:
            k_iter += 1
            the_list.append(i)

        if k_iter == n:
            return the_list

    raise Exception ("Did not reach k_iter, before end of array")

def main():
    parser = OptionParser(" Usage: facebook-ex1 --inputFile sample.txt")
    parser.add_option('-i', '--inputFile', type = 'string', dest='inputFile',
                         help='Pass in a user generated file')

    (options, args) = parser.parse_args()

    print options

    fileLines = []

    if options.inputFile is not None:
        print "yes"
        filePath = options.inputFile
        with open(filePath) as f:
            fileLines = f.read().splitlines()
    else:
        raise Exception ("Where is the bloody file")

    count = int(fileLines[0])

    for i in range(0,count):
        n,k= [int(x) for x in fileLines[1+2*i].split(" ")]
        a,b,c,r = [int(x) for x in fileLines[2+2*i].split(" ")]
        print a,b,c,r,n,k
        array_original= create_original(r)
        apply_function(array_original, a, b, c, r, k)
        print array_original
        list = return_min_integer_list(array_original, k, n)
        print list
        print "Case #%d: %d" % (i, list[-1])

if __name__ == '__main__':

    main()