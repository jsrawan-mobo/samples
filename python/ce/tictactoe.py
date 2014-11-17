# To go faster m = 1000

# So avoid going through 1M squares.  We would need to do 4 types.  So could be 4 * 1000
# This is pretty fast, so i don't think it be a problem
# We know the sum of any board is M


class TicTacToe(object):
    def __init__(self, m):
        self.the_board = [[False for x in xrange(m)] for y in xrange(m)]

    def is_game_over(self, x, y):

        m = len(self.the_board)

        is_done = all([self.the_board[xi][y] for xi in xrange(m)])
        if is_done:
            return True

        is_done = all([self.the_board[x][yi] for yi in xrange(m)])
        if is_done:
            return True

        if x / y == 1:
            is_done = all([self.the_board[pos][pos] for pos in xrange(m)])

            if ((x - 1 - m) / y) == 1:
                is_done = all([self.the_board[pos - 1 - m][pos] for pos in xrange(m)])

            if is_done:
                return True

        return False

    def make_move(self, x, y):
        if not self.the_board[x][y]:
            self.the_board[x][y] = True
        else:
            raise Exception("Already taken")
        return True


if __name__ == '__main__':

    ttt = TicTacToe(3)
    ttt.make_move(0, 0)
    ttt.make_move(1, 1)
    ttt.make_move(2, 2)
    if ttt.is_game_over(2, 2):
        print "Finished game"

    ttt = TicTacToe(3)
    ttt.make_move(0, 0)
    ttt.make_move(1, 1)
    ttt.make_move(1, 2)
    if not ttt.is_game_over(1, 2):
        print "Not Done"

    ttt.make_move(0, 2)
    ttt.make_move(2, 2)

    if ttt.is_game_over(2, 2):
        print "Finished game"
