# // Input: Any number of already sorted lists.
# // Output: One list of all elements in sorted order.
# //
# // N sorted lists, and average size of each list is k elements.
#
# // a = ['aaa','aab','aac']
# // b = ['caa','cab','ccc']
# // c = ['daa','dab','dcc']
# //
# //
# // mean(len(a)) = k
# //
# // output = ['aaa','aab','aac','caa','cab','ccc']
# //
# // assume a and b, string length is variable.
# //
# // pointer p = always points to the current element to be inserted into new list
# // the next element will be the least weight
# //
# // o(1) insert * o(n)
# // n=100
# // k=1000
# // k >> n
# // o(n) = 0(1)*o(n^2)
# //
# // len(output) = n*k
# // n^2 * k.
# // Nk total elements, each element O(N)



def sort_lists(l_of_strings):
  """
  :params l_of_strings: Is a list of lists of strings
  """

  p_l = [0 for x in xrange(len(l_of_string))]

  output = []

  # When popping of a list, and there is no elements, remove the list the list altogether
  while len(l_of_strings) > 0:
      min_string = l_of_strings[0][p_l[0]]
      for i in xrange(1,len(p_l)):
          new_string = l_of_strings[i][p_l[i]]
          if new_string < min_string:
              new_string = min_string

      output.append(new_string)

  return output