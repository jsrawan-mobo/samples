from sys import argv

#
# Two sequences where the greatest subsequence, which is NON continguous
# assume only one unique
# Create a recursive sequence, that basically takes the left, and walks through all possibilities
# Its recursive

# This below will two strings and find the maximal possible sequence
# Starting at first leter

def subsequence(x, y):

    print x + "--" + y
    if len(x) <= 1 or len(y) <= 1:
        if x[0] == y[0]:
            return [x[0]]
        else:
            return []

    if x[0] == y[0]: #keep going
        subs = subsequence(x[1:], y[1:])
        return [x[0]] + subs

    else : #Now we have to go through all permutations

        sub1 = subsequence(x[1:], y)
        sub2 = subsequence(x, y[1:])

        if len(sub1) == 0 and len(sub2) == 0:
            return []
        elif len(sub1) > len(sub2):
            return sub1
        else:
            return sub2

if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)
    flist = [tuple([y for y in x.replace("\n", '').split(';')]) for x in input.readlines() if len(x.strip()) > 0]

    for k, fl in enumerate(flist):
        if k >= 0:
            result = subsequence(fl[0], fl[1])
            print ''.join(result)
