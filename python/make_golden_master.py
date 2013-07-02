import trivia
import random

for seed in range(0,100):
    print "Game for seed %s" % seed
    random.seed(seed)
    trivia.main()
