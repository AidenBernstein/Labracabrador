import time
import string
import random

def mod(user):
    dif = random.randrange(12, 24, 1) - len(user)
    if dif > 0:
        user += ''.join(random.choices(string.ascii_letters, k=dif))
    if dif < 0:
        user = user[:dif]
    
    key = []
    for char in user:
        key.append(str(chr((int(ord(char) + time.time()) % 93) + 33)))
        key.reverse()
    
    return ''.join(key)

user = input("user")
key = mod(user)
print(key)