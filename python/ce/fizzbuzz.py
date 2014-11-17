# sequential numbers, with any number divisible by X is replaced with fizz,
# and y by buzz
# The file contains, X, Y , N
#
from sys import argv


def fizzbuzz(x, y, n):

    seq_o = []
    for i in xrange(1, n+1):

        o = ""
        if i%x == 0:
            o += "F"
        if i%y == 0:
            o += "B"
        if len(o) < 1:
            o = str(i)
        seq_o.append(o)
    return seq_o

if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)
    flist = [tuple([int(y) for y in x.replace("\n", '').split(' ')]) for x in input.readlines()]

    for fl in flist:
        result = fizzbuzz(fl[0], fl[1], fl[2])
        print ' '.join(result)