import numpy as np
import matplotlib.pyplot as plt
import mariadb as db
import sys

from datetime import date

imagePath = "/nfs/Images"

def queryPassword():
    f = open("/passwords/pw.ini", "r")
    passwd = f.readline()
    f.close()
    return passwd.split(':')

logfile = open("/var/log/stats/Stats.log", "a")
print(f"{date.today()}\n", file=logfile)

try:
    print(f'Connecting to database...', file=logfile)
    id = queryPassword()
    conn = db.connect(
        user=id[0].strip('\n'),
        password=id[1].strip('\n'),
        host="10.1.0.4",
        database="influenceurs"
    )
    print(f'Connected to database', file=logfile)
    cursor = conn.cursor()
    print(f'Cursor created.Ready to query in database', file=logfile)
    
    cursor.close()
    conn.close()
    print(f'Disconnected from database', file=logfile)
except db.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}", file=logfile)
    logfile.close()
    sys.exit(1)

except Exception as e:
    print(f"Error: {e}", file=logfile)
    logfile.close()
    sys.exit(1)