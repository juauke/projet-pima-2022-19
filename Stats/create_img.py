import matplotlib.pyplot as plt
import numpy as np
import random
import mariadb as db

hist = []

def queryPassword():
    f = open("/passwords/pw.ini", "r")
    passwd = f.readline()
    f.close()
    return passwd.split(':')

id = queryPassword()

conn = db.connect(
        user=id[0].strip('\n'),
        password=id[1].strip('\n'),
        host="10.1.0.4",
        database="utilisateurs"
    )
cursor = conn.cursor()

cursor.execute("SELECT username FROM youtube LIMIT 4 OFFSET 1;")
usernames = cursor.fetchall()

cursor.close()
conn.close()

abos_jdg = np.array([1e5, 153456, 354697, 478962, 1332691, 2357995, 3720056], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés "+usernames[0][0])
plt.legend()
plt.savefig("/nfs/Images/abos_jdg.png")
hist.append(abos_jdg[-1])

plt.clf()
abos_jdg = np.array([1.2e5, 435615, 326548, 635481, 698754, 1.1e7, 1.8e7], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés "+usernames[1][0])
plt.legend()
plt.savefig("/nfs/Images/abos_hubert.png")
hist.append(abos_jdg[-1])

plt.clf()
n=random.randrange(8e5, 12e5)
p = random.random() + 1
abos_jdg = np.array([n * (p ** k) for k in range(7)], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés "+usernames[2][0])
plt.legend()
plt.savefig("/nfs/Images/abos_dolores.png")
hist.append(abos_jdg[-1])

plt.clf()
n=random.randrange(8e5, 12e5)
p = random.random() + 1
abos_jdg = np.array([400000, 635210, 1.1e6, 1.3e6, 1.5e6,2e6, 2.2e6], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés "+usernames[3][0])
plt.legend()
plt.savefig("/nfs/Images/abos_Armand.png")
hist.append(abos_jdg[-1])

plt.clf()
labels = [x[0] for x in usernames]
plt.bar(labels, hist)
plt.savefig("/nfs/Images/hist.png")