from optparse import OptionParser
from collections import deque
import numpy
import sys


class numpy_deque(object):

    def __init__(self, size):
        self.deque_obj = numpy.zeros((size,1),dtype=numpy.int32)
        self.size = size
        self.l = 0
        self.r = -1

    def __len__(self):
        if self.r > self.l:
            return self.r - self.l + 1
        else :
            return self.r + len(self.deque_obj) - self.l + 1


    def popleft(self):
        item = self.deque_obj[self.l]
        self.l += 1
        if self.l >= self.size:
            self.l = 0
        return item * 1

    def append(self, item):

        if self.r != -1 and self.r == (self.l - 1):
            self.l += 1
            print "WARNING: overlapping queue left pointer, erasing object"

        self.r += 1
        if self.r >= self.size:
            self.r = 0

        self.deque_obj[self.r] = item * 1
        return item

    def __getitem__(self, key):

        if key > 0:
            i = self.l + key * 1
        else:
            i = self.r + key + 1  * 1
        return self.deque_obj[i] * 1

    def __setitem__(self, key, value):
        if key>0:
            i = self.l + key  * 1
        else:
            i = self.r + key  * 1
        self.deque_obj[i] = value

def create_original(r):

    #array_original = [0 for x in range(0,r,1)]
    #array_original = [0] * r
    array_original = numpy.zeros((r,1), dtype=numpy.int8)

    #print sys.getsizeof(numpy.int8(1))
    #print array_original.dtype.name
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
        array_original[m] += 1

        #else:
        #    raise Exception("Duplicates!")
        #    break #optimization, we will repeat for ever, no point of continuing (i think, just the number is sufficient.


def find_min(array_original, start_i):
    return 0
    i = start_i
    n = len(array_original)
    while start_i < n:
        v = array_original[i]
        if v == 0:
            array_original[i] += 1
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
    the_list = numpy_deque ( min(k+1,n-k+1) )
    seq = generate_sequence(a,b,c,r,k).__iter__()
    finish_original = False
    for k_i in range (k, n + 1):

        #Find the minimal and use it
        i = find_min(array_original, i)
        the_list.append(i)
        #i+=1

        #find out what sequence was, and reduce it
        if not finish_original:
            try:
                m_i = seq.next()
            except Exception, e:
                finish_original = True

        if finish_original:
            m_i = the_list.popleft()
        array_original[m_i] -= 1

        #hint to tell us that we have a new min.
        if m_i < i:
            i = m_i

        #Tbd if we run out of the function, then we have to pop the list.
        if k_i == n-1:
            return the_list

    raise Exception ("Did not reach k_iter, before end of array")

def main(options):
    print options
    return
    fileLines = []

    if options.inputFile is not None:
        print "yes"
        filePath = options.inputFile
        with open(filePath, "r") as f:
            fileLines = f.read().splitlines()
    else:
        raise Exception ("Where is the bloody file")

    count = int(fileLines[0])

    for i in range(0,count):
        n,k= [int(x) for x in fileLines[1+2*i].split(" ")]
        a,b,c,r = [int(x) for x in fileLines[2+2*i].split(" ")]
        #print a,b,c,r,n,k
        array_original= create_original(r)
        apply_function(array_original, a, b, c, r, k)
        #print array_original
        list = return_min_integer_list(array_original, a, b, c, r, k, n)
        #print list
        print "Case #%d: %d" % (i+1, list[-1])
        #break

if __name__ == '__main__':
    parser = OptionParser(" Usage: facebook-ex1 --inputFile sample.txt")
    parser.add_option('-i', '--inputFile', type = 'string', dest='inputFile',
                         help='Pass in a user generated file')

    (options, args) = parser.parse_args()

    main(options)
