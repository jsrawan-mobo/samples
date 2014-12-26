from itertools import permutations, chain
from sys import argv

#
# Two sequences where the greatest subsequence, which is NON continguous
# assume only one unique
# Create a recursive sequence, that basically takes the left, and walks through all possibilities
# Its recursive

# This below will two strings and find the maximal possible sequence
# Starting at first leter
import re
import math


def slope(cc):
    return (cc['yr'] - cc['yl']) / (cc['xr'] - cc['xl'])


def is_overlapping_box(c1, c2):
    """
    The simple approximatation will turn the lines into 2D boxes, that we can
    easily computer overlap.  This is for set assignment

    :param c1: dict of  xl,yl,xr,yr
    :param c2: dict of  xl,yl,xr,yr
    :return: the overlapping box or None
    """

    # figure out the slope and reverse the logic if slopes are not the same sign

    m1 = slope(c1)
    m2 = slope(c2)

    reverse = False
    if m1 * m2 < 0:
        reverse = True

    if (c1['xl'] <= c2['xr'] and c2['xl'] <= c1['xr']):

        if ((not reverse and (c1['yl'] <= c2['yr'] and c2['yl'] <= c1['yr']))
            or (reverse and (c1['yl'] >= c2['yr'] and c2['yl'] >= c1['yr']))):

            return {
                'xl': min(c1['xl'], c2['xl']),
                'xr': max(c2['xr'], c2['xr']),
                'yl': max(c1['yl'], c2['yl']),
                'yr': min(c1['yr'], c2['yr'])
            }

        return None


def is_colliding_line(c1, c2):
    """
    Using line to line intersection described here:
    http://en.wikipedia.org/wiki/Line%E2%80%93line_intersection

    x = (b2.- b1) / (m1 - m2)
    y = (b2*m1 - b1*m2) (m1 - m2)

    Take l1, and make that intercept = 0
    Take l2 and find its y intercept = 0
    then we can find point of instersection using equations


    :return : None if no overlap or the coordinate of the x,y point (its a line as a point)
    """

    y_f = lambda m, x, b: m * x + b
    x_f = lambda m, y, b: (y - b) / m

    def swap_if(c):
        if c['xr'] < c['xl']:
            return {'xl': c['xr'],
                    'yl': c['yr'],
                    'xr': c['xl'],
                    'yr': c['yl']}
        else:
            return c

    # This works only if the first point is on the left, we swap the points if required

    c1 = swap_if(c1)
    c2 = swap_if(c2)


    # Setup the m and b for the linear equation.  The number represent the number degrees of y
    # over x.
    # to get the number of degree slop of line
    # >> math.degrees(math.atan(c1m)
    c1m = slope(c1)
    c2m = slope(c2)

    # Now we set up the b valuea to represent the at x=x0 (like x=0).  We pick
    x0 = c1['xl']
    c1b = c1['yl']
    c2b = y_f(c2m, x0 - c2['xl'], c2['yl'])

    # Now find the x,y point that overlaps.  If m are equal (parallel lines)
    # then we get infinite answer
    try:
        x_i = (c2b - c1b) / (c1m - c2m) + x0
        y_i = (c2b * c1m - c1b * c2m) / (c1m - c2m)
    except Exception:
        return None


    # Now the easy part, make sure the xi,yi is in the bounding box for both lines
    eps = 1e-6
    c_i = {'yl': y_i - eps, 'xl': x_i - eps, 'yr': y_i + eps, 'xr': x_i + eps}

    if is_overlapping_box(c1, c_i) and is_overlapping_box(c2, c_i):
        return {'yl': y_i, 'xl': x_i}

    return None


def group_by_bounding_box(coords):
    """
    First take a a set of coordinates, and bounding boxes to find set members
    Within each set split any that actually are overlaping
    Then for those final overlaps, start iterating through recursively
    to find all combineations (n^2)

    Our assumption is we can reduce overlaping down to point where
    the n^2 algorithm is on small enough set.
    """

    # First do some grouping to reduce our data set.  the key will the overlapping box
    # Do additional assignment

    # BoundingBox = namedtuple("BoundingBox", ['idb', 'groups'])

    groups_list = []
    for id, coord in coords.iteritems():
        group_found = None
        for boundingbox in groups_list:
            idb = is_overlapping_box(boundingbox['idb'], coord)
            if idb:
                boundingbox['groups'].append((id, coord))
                boundingbox['idb'] = idb
                group_found = idb
                break
        if group_found is None:
            groups_list.append({'idb': coord, 'groups': [(id, coord)]})

    return groups_list

    # Second do


# Another option is just to find a random overlap, and remove
# The one that has less overlaps.
# Prune operation can be recursive
def group_by_overlapping_2(groups):
    """
    :param groups:
    :return:
    """
    pass


def group_by_overlapping(groups):
    """
    Simply keep adding to a group if anything matches
    :param groups:
    :return:  a list of of list of groups that overlap
    """

    def is_group_colliding(coord, groups):
        for id, coordg in groups:
            if is_colliding_line(coord, coordg):
                return True

        return False

    # This is n^2 to find interesection
    sub_groups = []
    for id, coord in groups:
        found_groups = []
        found_group_index = []

        for k, sgroups in enumerate(sub_groups):
            if is_group_colliding(coord, sgroups):
                found_groups += sgroups
                found_group_index.append(k)

        if len(found_groups) > 0:

            for k, ind in enumerate(found_group_index):
                del sub_groups[ind - k]
            found_groups.append((id, coord))
            sub_groups.append(found_groups)
        else:
            sub_groups.append([(id, coord)])

    return sub_groups


def gcdf(groups):
    """
    Take the permutations at the top level, then for
    each permutation, do a recursion to find the gc subgroup

     :param groups_list:
    :return:  a list of of list of groups that overlap
    """

    def is_group_colliding(coord, groups):
        for id, coordg in groups:
            if is_colliding_line(coord, coordg):
                return True
        return False

    def gcfd_recurse(groups):
        """
        Left tree is the group, right tree
        :param groups:
        :return:
        """
        n = len(groups)
        gcfd_ret = []
        for id, coord in groups:
            if not is_group_colliding(coord, gcfd_ret):
                gcfd_ret.append((id, coord))
        return gcfd_ret

    all_perms = permutations(groups, len(groups))

    longest = []
    for perm in all_perms:

        gcfd_group = gcfd_recurse(perm)
        if len(gcfd_group) > len(longest):
            longest = gcfd_group
        if len(longest) >= len(groups) - 1:
            return gcfd_group

    return longest


def hsv_to_rgb(h, s, v):
    if s == 0.0:
        v *= 255
        return [v, v, v]

    # XXX assume int() truncates!
    h = h / 60
    i = int(h)
    f = h - i
    v *= 255
    p = int(v * (1. - s))
    q = int(v * (1. - s * f))
    t = int(v * (1. - s * (1. - f)))
    i %= 6

    if i == 0:
        return [v, t, p]
    if i == 1:
        return [q, v, p]
    if i == 2:
        return [p, v, t]
    if i == 3:
        return [p, q, v]
    if i == 4:
        return [t, p, v]
    if i == 5:
        return [v, p, q]


if __name__ == "__main__":

    file_name = argv[1]

    input = file(file_name)
    flist = [tuple([y for y in x.replace("\n", '').split(':')]) for x in input.readlines() if
             len(x.strip()) > 0 and x[0] != '#']
    coords = dict()
    floatre = re.compile(
        '([\-\+]?\d+\.\d+)[\s,\]\[]*([\-\+]?\d+\.\d+)[\s,\]\[]*([\-\+]?\d+\.\d+)[\s,'
        '\]\[]*([\-\+]?\d+\.\d+)')
    for id, val in flist:
        res = floatre.search(val)
        if not res:
            raise Exception("Invalid input line {}".format(val))

        coords[id] = {'yl': float(res.group(1).strip()), 'xl': float(res.group(2).strip()),
                      'yr': float(res.group(3).strip()), 'xr': float(res.group(4).strip())}

    # for id1, coord1 in coord.iteritems():
    # for id2, coord2 in coord.iteritems():
    #
    # box = is_overlapping_box(coord1, coord2)
    # line = is_colliding_line(coord1, coord2)
    #
    # print "{}-{}-{}-{}".format(id1, id2, box, line)
    # groups_list = group_by_bounding_box(coords)
    # groups_only = [idb_groups['groups'] for idb_groups in groups_list]


    # tHIS OVERLAPS ALL OF THEM
    groups_only = [[(id, coord) for id, coord in coords.iteritems()]]

    intersect_groups = []
    for groups in groups_only:
        intersect_groups += group_by_overlapping(groups)

    import matplotlib.pyplot as pyplot

    for k, groups in enumerate(intersect_groups):

        for id, coord in groups:
            h, s, v = (int(k) * 60, 1, 1)
            r, g, b = hsv_to_rgb(h, s, v)
            color = '#{:02x}{:02x}{:02x}'.format(r, g, b)
            pyplot.plot([coord['xl'], coord['xr']], [coord['yl'], coord['yr']], color=color,
                        linestyle='-', linewidth=2, label=id)

            pyplot.text(coord['xl'], coord['yl'], '{}[{}]'.format(k, id), size=9, rotation=12,
                        color=color,
                        ha="center", va="center", bbox=dict(ec='1', fc='1'))

    pyplot.legend()
    pyplot.title("Groups")
    pyplot.show()

    final_groups = []
    for groups in intersect_groups:
        final_groups += gcdf(groups)

    coord_dict = dict([(int(groups[0]), groups[1]) for groups in chain(final_groups)])

    for key in sorted(coord_dict.keys()):
        print key

    import matplotlib.pyplot as pyplot

    for id, coord in coords.iteritems():

        h, s, v = (int(id) * 50, 1, 1) if int(id) in coord_dict else (360, 0, 0)

        r, g, b = hsv_to_rgb(h, s, v)
        color = '#{:02x}{:02x}{:02x}'.format(r, g, b)
        pyplot.plot([coord['xl'], coord['xr']], [coord['yl'], coord['yr']], color=color,
                    linestyle='-', linewidth=2, label=id)


        rotation = 0
        pyplot.text(coord['xl'], coord['yl'], '{}-{}\n{}'.format(id, coord['xl'], coord['yl']),
                    size=6, rotation=rotation, color=color,
                    ha="center", va="center", bbox=dict(ec='1', fc='1'))

        pyplot.text(coord['xr'], coord['yr'], '{}-{}\n{}'.format(id, coord['xr'], coord['yr']),
                    size=6, rotation=rotation, color=color,
                    ha="center", va="center", bbox=dict(ec='1', fc='1'))

    pyplot.legend()
    pyplot.title("Non-Intersecting lines")
    pyplot.show()


