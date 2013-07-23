import json

__author__ = 'jag'

from optparse import OptionParser
from abc import ABCMeta, abstractmethod, abstractproperty
from datetime import timedelta
from datetime import datetime


# This should take some input and regex the output.
#
#
#


def testfunction():

        m = 20
        x = 5
        b = 10
        y = m*x +b
        rem = y%x
        if y%x == 0:
            print 'y', m*x+b
        else:
            print 'rem', rem

        print "Hello %d, This is float %f.  Note the following is format anything %r" % (
            y, 1.223, '1281234.haha'
        )
        print "Single Quotes cannot be y"


class ExampleClass(object):

    """
    Note Variables should be initialized up here and for documentation purposes
    defined ahead of time.
    @type _instDictVar: dict
    """
    _instDictVar = {}


    def __init__(self, instDictVar):
        """
        @type instDictVar: dict
        @rtype: void
        """
        self._instDictVar = instDictVar

    def collect(l, index):
        #this returns a map that can be used to call index on.
       return map(itemgetter(index), l)





    def functionpacker(self, someArray):


        """
        @type someArray: list
        """
        someArray.pop()
        print "Before" , someArray
        someArray.pop()
        print "After" , someArray

        print "Before" , self._instDictVar
        self._instDictVar['charlie'] = len('charlie')
        del (self._instDictVar['bob'])
        print "After" , self._instDictVar

    @abstractmethod
    def __trunc__(self):
        pass


def main():


    """

    """
    parser = OptionParser(" Usage: inputandregex --input somefile.json")
    parser.add_option('-i', '--input', type = 'string', dest='inputFile',
                         help='Pass in a user generated file')

    (options, args) = parser.parse_args()

    print options

    if options.inputFile is not None:
         print "yes"
         filePath = options.inputFile
         fileIn = open(filePath)
         paramJson = fileIn.read()
         fileIn.close()
         loadRows = json.loads( paramJson )
    else:
         theData = 1

    testfunction()
    testfunction()
    print "run me"

    x = [1,2,3,4,5,6]
    dict = { "jag" :3 , "bob":3}

    obj = ExampleClass(dict)
    obj.functionpacker(x)


if __name__ == '__main__':



    """
    @type timerx: timedelta
    """

    start = datetime.now()
    end = datetime.now()
    timerDiff = end - start
    timerx = timedelta()
    print timerx.total_seconds()
    print timerDiff


    main()