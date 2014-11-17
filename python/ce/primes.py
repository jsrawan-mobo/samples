#
# palindrome detection
# So L to R is the range of numbers, and is "interesting" if we have even number of palindromes
# Example   1, 2 =>
# Example   1,7 => 1234567
#


def is_prime(k):
    """
    A number is prime, if you 1 and itself is the only divisor
    #So start at 2,3,4,5,6,7,8 and find if any of them divde through
    you can do from 2 to n/2
    :return:
    """

    for i in xrange(2, int(k / 2) + 1):
        if k % i == 0:
            return False

    return True


def first_n_primes(n):
    cnt = 0
    k = 2
    prime_sum = 0
    while cnt < n:
        if is_prime(k):
            prime_sum += k
            cnt += 1
        k += 1
    return prime_sum


if __name__ == "__main__":

    # n_primes = argv[1]
    n_primes = 1000

    sum = first_n_primes(n_primes)
    print sum