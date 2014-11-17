
"""
Task: write a function to deteemine if a string is
'balanced'. Balanced means that opening and closing
brackets match eachother in the proper order. Other
characters are possible and should be handled. The 
possible characters for balancing are {}, (), and []

Example Input:

'{}' -> True
'{[]}' -> True
'{5}' -> True
'{[}' -> False
'[A]{}d()' -> True
'a' -> True
'a}' -> False
'([)]' -> False
"""

def balanced(s):
    """
    Take each bracket {[( and make sure its dual is on the other end )]}
    """
    
    # For optimization, create the reverse list so it cached
    b_lookup = {'{': '}', '[': ']', '(': ')'}
    b_rev = set(b_lookup.values())

    # This is an array acting as a lifo stack.  Only append or pop to it
    b_lifo = []

    for x in s:
        if x in b_lookup:
            b_lifo.append(b_lookup[x])

        elif x in b_rev:
            if len(b_lifo) < 1 or b_lifo.pop() != x:
                return False        

    if len(b_lifo) == 0:
        return True
    else:
        return False

if __name__ == "__main__":

    inputs = [('{[]}', True),
              ('{}', True),
              ('{[]}', True),
              ('{5}', True),
              ('{[}', False),
              ('[A]{}d()', True),
              ('a', True),
              ('a}', False),
              ('([)]', False)]

    for i, x in enumerate(inputs):

        ##This is for testing a single one
        #if i != 2:
        #    continue
        if balanced(x[0]) != x[1]:
            raise Exception("Failed {} {}".format(x[0],x[1]))
        else:
            print "Passed {}".format(i)


    print "All successful, now go write a real compiler"


"""
def reverse_string(s):
    num = int(len(s)/2)

    sa = list(s)
    
    for k in xrange(num):        
        ik = len(s) - k - 1
        saved = sa[k]
        sa[k] = sa[ik]
        sa[ik] = saved                

    return ''.join(sa)
   """
    
