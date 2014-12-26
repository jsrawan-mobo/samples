from collections import namedtuple


def diag_proper(mat):
    """
    So y is going from 0 to 2,
    Then we do x from 1 to 2

    input = [
      [1,2,3],  y=0
      [4,5,6],  y=1
      [7,8,9],  y=2
    ]x=0,1,2


    Do the y, then transpose and do it again.


    Note the movement of from the positin, and the number of times, should be the key
    to solving.  Direction can be added.

    :param x:
    :return:
    """

    # def transpose(m):
    # l = len(m)

    def diagnol(m, s=0, l=None, xdir=+1, ydir=-1):
        l = len(m) if l is None else l
        outer = []
        for y in xrange(s, l):
            inner = []
            if ydir == -1:
                r = xrange(0, y + 1)
            else:
                r = xrange(0, l - y, 1)
            for n in r:
                inner.append(m[y + n * ydir][0 + n * xdir])
            outer.append(inner)

        return outer

    def like_transpose(m):
        l = len(m)
        o = [[None for y in xrange(l)] for x in xrange(l)]
        for x in xrange(0, l):
            for y in xrange(0, l):
                o[x][l - y - 1] = m[y][x]

        return o

    d_l = diagnol(mat, 0, len(mat))
    dlt = like_transpose(mat)
    d_r = diagnol(dlt, 1, len(mat), ydir=+1)

    d = d_l + d_r
    return d


def diag_inplace(mat):
    """
    Do without a transpose and notice that the

    iter,maxn,start
    0#    1 # 0 #(0,0) =>
    1#    2 # 0 #(0,1) (1,0) =>
    2#    3 # 0 #(0,2) (1,1) (2,0) =>
    3#    2 # 1 #(1,2) (2,1) =>
    4#    1 # 2 #(2,2) =>

    What are all the ways to add up to a number, given a max of the n-1

    Recall that the matrix is accessed m[y][x]

    """
    MTuple = namedtuple('Mtuple', ['x', 'y'])

    def maxn(i, n):
        return i + 1 if i < n else 2 * (n - 1) - i + 1

    def all_max(start, maxn, sum):
        for x in xrange(start, start + maxn):
            yield MTuple(x, sum - x)

    def start(i, n, maxn):
        return 0 if i < n else n - maxn

    n = len(mat)
    result = []
    for iter in xrange(0, 2 * (n - 1) + 1):
        max_n = maxn(iter, n)
        start_i = start(iter, n, max_n)
        tuples = all_max(start_i, max_n, iter)
        result.append([mat[t.y][t.x] for t in tuples])
    return result


def diag(x):
    """
    Ass backards, xx is going down, yy is going up
    :param x:
    :return:
    """
    n = len(x)
    output = []
    for lx in xrange(0, n):
        inner = []
        for ly in xrange(0, lx + 1):
            inner.append(x[lx - ly][ly])
        output.append(inner)

    # Start at x=2, y=1 and -1, -1
    for ry in xrange(1, n):
        inner = []
        for rx in xrange(n - 1, ry - 1, -1):
            inner.append(x[rx][ry - rx + n - 1])
        output.append(inner)

    return output


if __name__ == "__main__":

    input = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
    ]

    o = diag(input)

    output = [
        [1],
        [4, 2],
        [7, 5, 3],
        [8, 6],
        [9],
    ]

    def larger_by(input, x_axis):
        if x_axis:
            return [x + x for x in input]
        else:
            input.extend([x for x in input])
            return input

    x_larger = larger_by(input, True)
    y_larger = larger_by(x_larger, False)
    assert (o == output)

    dp = diag_proper(input)
    assert (dp == output)

    dp = diag_inplace(input)
    assert (dp == output)

    import timeit

    dp_l = diag_inplace(y_larger)

    output_l = [[1], [4, 2], [7, 5, 3], [1, 8, 6, 1], [4, 2, 9, 4, 2], [7, 5, 3, 7, 5, 3],
                [8, 6, 1, 8, 6], [9, 4, 2, 9], [7, 5, 3], [8, 6], [9]]
    assert (output_l == dp_l)

    def diag_inplace_timer():
        diag_inplace(y_larger)

    # Implementation 1 Baseline - Total time 1.18796873093, per loop, 1.18796873093e-08
    # Implementation 2 generator - Total time 1.1867172718, per loop, 1.1867172718e-08
    r = 10000
    n = 10000
    t = timeit.Timer("diag_inplace_timer", "from __main__ import diag_inplace_timer").repeat(r,n)
    print "Total time {}, per loop, {}".format(sum(t), sum(t)/n/r)


