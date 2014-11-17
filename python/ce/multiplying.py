# double Pow(double a,  int b)
#hello
#a ^ b
#python
#5 * 5 = 25
#5^4
#525 * 25

    if b == 0:
        return 1

    if a == 0:
        return 0

    double do_recursive_pow (a, b)

        if b == 1:
            return a

        if b%2 == 0:
            x = do_recursive_pow(a, floor(b/2))
            return x * x
        else:
            x = do_recursive_pow(a, floor(b/2))
            return x * x * a


    x = do_recursive_power(a, abs(b))
    if b < 0:
        x = 1/x

    return x

