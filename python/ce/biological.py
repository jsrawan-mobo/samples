from itertools import chain
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


def subsequence(x, y):
    def subsequence_recursive(x, y):
        # print x + "--" + y
        if len(x) <= 1 and len(y) <= 1:
            if x[0] == y[0]:
                return [x[0]]
            else:
                return []

        if len(x) <= 1:
            sub1 = subsequence(x, y[1:])
            return sub1

        if len(y) <= 1:
            sub1 = subsequence(x[1:], y)
            return sub1

        if x[0] == y[0]:  # keep going
            subs = subsequence(x[1:], y[1:])
            return [x[0]] + subs

        else:  # Now we have to go through all permutations

            sub1 = subsequence(x[1:], y)
            sub2 = subsequence(x, y[1:])

            if len(sub1) == 0 and len(sub2) == 0:
                return []
            elif len(sub1) > len(sub2):
                return sub1
            else:
                return sub2

    matching_set = set(x) & set(y)

    new_x = [c for c in x if c in matching_set]
    new_y = [c for c in y if c in matching_set]

    return subsequence_recursive(new_x, new_y)


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

def sequence_gene_1(x, y):
    """
    So the we want to generate sequences that are
    in order of likely to be best fit to worst.

    Assumptions : If all letters match, then we can draw those character out of main string
    If those are the same characters, its a match and that is only O(1) solution

    1) Get the maximal subsequence possible

    2) Then try to do optimal weighting.  This can be inferred by:
    RANK of following
    Match + 3
    non-match -3
    range of None -1
    single None -8



    :param x:
    :param y:
    :return:
    """
    max_seq = subsequence(x, y)

    def first_vector(vec, seq):
        s_queue = list(reversed(list(seq)))
        s_best = []

        for k, c in enumerate(vec):
            if len(s_queue) > 0 and c == s_queue[-1]:
                s_best.append(s_queue.pop())
            else:
                s_best.append(' ')
        return s_best

    def filled_vector(vec, seq, spaces):
        """
        superimpose vec onto seq where possible
        :param vec:
        :param seq:
        :return:
        """
        if len(vec) != len(seq):
            raise Exception("Lengths must be the same")

        for k in xrange(0, len(seq)):

            if vec[k] == seq[k]:
                continue

            if seq[k] == ' ' and spaces[k]:
                seq[k] = vec[k]

        return seq




    all_scores = []
    if len(x) >= len(y):
        s_best = first_vector(x, max_seq)

        if len(x) == len(y):
            s_dual = first_vector(y, max_seq)
            s_spaces = [True if k == ' ' else False for k in s_dual]
            s_best = filled_vector(y, s_best, s_spaces)

        final_score = final_scoring(x, ''.join(s_best))
        all_scores.append(final_score)


    if len(y) >= len(x):
        s_best = first_vector(y, max_seq)
        final_score = final_scoring(y, ''.join(s_best))
        if len(x) == len(y):
            s_dual = first_vector(x, max_seq)
            s_spaces = [True if k == ' ' else False for k in s_dual]
            s_best = filled_vector(x, s_best, s_spaces)
        all_scores.append(final_score)

    return max(all_scores)

if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)

    test = False
    flist = []
    if test:
        flist = [tuple(chain.from_iterable([y.split('|') for y in x.replace("\n", '').split('=>')]))
                 for x in input.readlines()]
    else:
        flist = [tuple([y for y in x.replace("\n", '').split('|')])
                 for x in input.readlines()]

    for k, fl in enumerate(flist):


        if test:
            x, y, er = (x.strip() for x in fl)
            r = sequence_gene_1(x, y)
            print '{}=>{},{},{}={}'.format(k, x, y, r, er)
            assert (r == int(er.strip()))
        else:
            x, y = (x.strip() for x in fl)
            r = sequence_gene_1(x, y)
            print r
