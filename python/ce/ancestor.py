#
# The file contains, X, Y , N
#
from collections import defaultdict
from sys import argv


def lowest_ancestor(tree, a, b):
    """
    :param tree: edglist of tree
    :param a: first ancestor
    :param b: another ancestor
    :return: common parent
    """

    def find_all_descedents(tree, r, x):
        """
        start at a node, and return a set of descedents until we match
        for example, root noode, child1, child2, x
        r can be set to the root node.
        """

        if r == x:
            return [r]

        if r not in tree:
            return None
        else:
            all_desc1 = find_all_descedents(tree, tree[r][0], x)

            if all_desc1 != None:
                return [r] + all_desc1

            all_desc2 = find_all_descedents(tree, tree[r][1], x)
            if all_desc2 != None:
                return [r] + all_desc2

    a_d = find_all_descedents(tree, 30, a)[0:-1]
    b_d = find_all_descedents(tree, 30, b)[0:-1]

    # Find all in set that are common
    # for each element, save a dictionary of its vale and iteration number

    scores = defaultdict(int)
    for pos, a in enumerate(a_d):
        scores[a] += pos
    for pos, a in enumerate(b_d):
        scores[a] += pos

    # Figure out common nodes
    common = set(a_d) & set(b_d)

    # Now find the ancestor with smallest value
    final_item = None
    max_score = 0
    for item, score in scores.iteritems():
        if item in common and score >= max_score:
            max_score = score
            final_item = item

    return final_item


def buildtree():
    """
    Create edge lists.  First entry is root.
    :return:
    """

    tree = {30: (8, 52),
            8: (3, 20),
            20: (10, 29)}

    return tree


if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)
    flist = [tuple([int(y) for y in x.replace("\n", '').split(' ')]) for x in input.readlines()]

    tree = buildtree()

    for fl in flist:
        result = lowest_ancestor(tree, fl[0], fl[1])

        if len(fl) > 2:
            #test mode
            assert fl[2] == result
        print result
