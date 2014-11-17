from sys import argv


def longest(input, num=2):
    """
    Find the longest n words.
    Use index of array to represent length.
    Push words into length
    Then  print out after
    :return:
    """

    longestv = [0 for x in xrange(1000)]
    for y in input.readlines():

        x = y.strip('\n')
        ind = len(x)

        if longestv[ind] == 0:
            longestv[ind] = [x]
        else:
            longestv[ind].append(x)

    found = list()
    for x in xrange(999, 0, -1):

        if longestv[x] != 0:
            found += longestv[x]

        if len(found) >= num:
            break

    return found






if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)

    num = int(input.readline().strip())
    result = longest(input, num)
    print result