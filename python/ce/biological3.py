from sys import argv


""""
DNA sequence is made of A,C,T,G

When we sequence two substrings
GAAAAAAT and GAAT
1=> GAAAAAAT
2=> G--A-A-T

so align the 2 subsequences up and then measure following.
YOU CANNOT PERMANENTLY DELETE A LETTER!

+3 for match
-3 for mismatch
-8 in/del start a sequence
-1 in/del continuation (therefore having a bunch of gaps, vs number of should be reduced

In following example
+3*4 -8*3 -1 = -13

The most optimal one is

GAAAAAAT
GAA----T

3*4 -8*1 -1*3 = 1


Another example

GCATGCU | GATTACA=>

GCATGCU
GATTACA

3*3 - 3*4 = -3



Basically the longest subsequence give you anchors.
Look through loop and when u get non-matching character


"""
DEBUG=True


def final_scoring(x, y):
    if len(x) != len(y):
        raise Exception("Scoring must be on exact length string")

    score = 0
    run = 0
    for n in xrange(0, len(x)):

        if x[n] == y[n]:
            score += 3
            run = 0
        elif x[n] is ' ' or y[n] is ' ':
            if run == 0:
                score -= 8
                run += 1
            else:
                score -= 1
                run += 1
        elif x[n] != y[n]:
            score -= 3
            run = 0

    return score


def return_all_sequences(smaller, bigger, s):
    """
    Takes a smaller sequence
    and tries to match atleast s characters

    Once a fit is found, we can iterate.
    If not fit found of tha size, we return emty

    # Currently the first_vector only find one possible scenario
    # We need a few more

    :param smaller:
    :param bigger:
    :param size:
    :return:
    """

    def all_vectors(vec, seq):
        """
        Finds the first sequence in vector that MUST match
        """
        start_pos = 0

        s_all = []
        while start_pos < len(vec):

            s_best = []
            s_queue = list(reversed(list(seq)))
            for k, c in enumerate(vec):
                if len(s_queue) > 0 and c == s_queue[-1] and k >= start_pos:
                    s_best.append(s_queue.pop())
                else:
                    s_best.append(' ')

            if all( s==' ' for s in s_best):
                start_pos = len(vec)
            else:
                start_pos = s_best.index(seq[0]) + 1
                if len(s_queue) < 1:
                    s_all.append(''.join(s_best))


        return s_all

    allx = []
    l = len(smaller)
    for k in xrange(0, l - s+1):
        subs_s = smaller[k:s+k]
        matched = all_vectors(bigger, subs_s)
        allx += matched

    return allx


def sequence_gene_1(x, y):
    """
    To sequence a gene, we want to find all max substrings of the smaller stirng
    to fit into the bigger string.

    AAAAAAAAAAGATTCAAAAAAAAAAACTTAG |
              GAT  XXXX       CTTAG

    - Find the most largest substrings,


    :param x:
    :param y:
    :return:
    """

    if len(x) == len(y):
        s = final_scoring(x, y)
        return s

    smaller = x if len(x) < len(y) else y
    bigger = x if len(x) > len(y) else y

    # For the smaller one, we follow pigeonhole principle
    # We only have choice of k deletion, where k = len(bigger) - len(smaller)
    # If we try randomly, then its a waste
    # We should ascertain how many characters MUST match, given the max subsequence?


    all_seq = []
    for k in xrange(len(smaller), 0, -1):
        all_seq = return_all_sequences(smaller, bigger, k)

        if len(all_seq) > 0:
            if DEBUG:
                print len(bigger), len(smaller),  k
                print all_seq
            break
    all_scores = [final_scoring(bigger, seq) for seq in all_seq]
    return max(all_scores)


if __name__ == "__main__":


    def chain_from_iterable(iterables):
        """
        itertools alternative
        :param iterable: take a list of [[a,b,c],[a,b,d]] and flattens it
        :return:
        """

        for x in iterables:
            for y in x:
                yield y


    file_name = argv[1]

    input = file(file_name)

    test = True
    flist = []
    if test:
        flist = [tuple(chain_from_iterable([y.split('|') for y in x.replace("\n", '').split('=>')]))
                 for x in input.readlines() if x[0] != '#']
    else:
        flist = [tuple([y for y in x.replace("\n", '').split('|')])
                 for x in input.readlines() if x[0] != '#']

    r = 1000
    n = 1000

    for k, fl in enumerate(flist):
        if k != 11:
            continue

        if test:
            import timeit
            x, y, er = (x.strip() for x in fl)

            def sequence_gene_1_t():
                return sequence_gene_1(x, y)

            rsp = sequence_gene_1_t()
            print '{}=>{},{},{}={}'.format(k, x, y, rsp, er)
            assert (rsp == int(er.strip()))

            sequence_gene_1_t = timeit.Timer("sequence_gene_1_t", "from __main__ import sequence_gene_1_t")
            t = sequence_gene_1_t.repeat(r,n)
            print "Total time {}, per loop, {}".format(sum(t), sum(t)/n/r)
        else:
            x, y = (x.strip() for x in fl)
            y = y.split("=>")[0].strip() #because it could our test file or theirs..
            rsp = sequence_gene_1(x, y)
            print rsp
