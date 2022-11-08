import numpy as np
import matplotlib.pyplot as plt

import mariadb as db

import sys

def queryPassword():
    f = open("/passwords/pw.ini", "r")
    passwd = f.readline()
    f.close()
    return passwd.split(':')

try:
    id = queryPassword()
    conn = db.connect(
        user=id[0].strip('\n'),
        password=id[1].strip('\n'),
        host="10.1.0.4",
        database="influenceurs"
    )
    
    conn.close()
except db.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)