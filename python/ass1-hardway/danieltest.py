from datetime import tzinfo, timedelta, datetime
from time import sleep
import sys

class Insight_Timer(object):

    def __init__(self, stream):
        self.stream = stream

    def __enter__(self):
        self.start=datetime.now()

    def __exit__(self, type, value, traceback):
        self.stop = datetime.now()
        duration = self.stop - self.start
        if not self.stream is None:
            print duration.total_seconds()
            # self.stream.write(duration.total_seconds())

with Insight_Timer(sys.stdout):
     sleep(1)