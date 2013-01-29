from optparse import OptionParser

def create_original(r):

    array_original = [True for x in range(0,r-1)]
    return array_original


def generate_sequence( a, b, c, r, k):
    m_old = a % r
    yield m_old
    for i in range (1, k):
        m_new = (b * m_old + c) % r
        yield m_new
        m_old = m_new


def apply_function(array_original, a, b, c, r, k):
    for m in generate_sequence(a,b,c,r,k):
        if array_original[m]:
            array_original[m] = False
        else:
            break #optimization, we will repeat for ever, no point of continuing (i think, just the number is sufficient.


def find_min_true(array_original, start_i):

    i = start_i
    n = len(array_original)
    while start_i < n:
        v = array_original[i]
        if v:
            array_original[i] = False
            return i
        i += 1

    raise "Exception could not find start_i"

def return_min_integer_list(array_original, a, b, c, r, k, n):
    """
    The very first integer is from the original list.
    However, after K slides, we need to turn on the previous one.
    This is best done by stepping through the function, and keeping
    the big array up to date, create a iterator
    @param array_original:
    @type array_original:
    @param k:
    @type k:
    @param n:
    @type n:
    @return:
    @rtype:
    """

    k_i = k
    i = 0
    the_list = []
    seq = generate_sequence(a,b,c,r,k).__iter__()
    for k_i in range (k,n + 1):

        #Find the minimal and use it
        i = find_min_true(array_original, i)
        the_list.append(i)
        i+=1

        #find out what sequence was, and reduce it
        m_i = seq.next()
        array_original[m_i] = True

        #hint to tell us that we have a new min.
        if m_i < i:
            i = m_i

        #Tbd if we run out of the function, then we have to pop the list.
        if k_i == n:
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
        list = return_min_integer_list(array_original, a, b, c, r, k, n)
        print list
        print "Case #%d: %d" % (i, list[-1])

if __name__ == '__main__':

    main()