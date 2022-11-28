import matplotlib.pyplot as plt
import numpy as np
import random

hist = []

abos_jdg = np.array([1e5, 153456, 354697, 478962, 1332691, 2357995, 3720056], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés JDG")
plt.legend()
plt.savefig("/nfs/Images/abos_jdg.png")
hist.append(abos_jdg[-1])

plt.clf()
abos_jdg = np.array([1.2e5, 435615, 326548, 635481, 698754, 1.1e7, 1.8e7], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés Hubert")
plt.legend()
plt.savefig("/nfs/Images/abos_hubert.png")
hist.append(abos_jdg[-1])

plt.clf()
n=random.randrange(8e5, 12e5)
p = random.random() + 1
abos_jdg = np.array([n * (p ** k) for k in range(7)], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés Dolorès")
plt.legend()
plt.savefig("/nfs/Images/abos_dolores.png")
hist.append(abos_jdg[-1])

plt.clf()
n=random.randrange(8e5, 12e5)
p = random.random() + 1
abos_jdg = np.array([400000, 635210, 1.1e6, 1.3e6, 1.5e6,2e6, 2.2e6], dtype = int)
plt.plot(range(7),abos_jdg, label="Abonnés Armand")
plt.legend()
plt.savefig("/nfs/Images/abos_Armand.png")
hist.append(abos_jdg[-1])

plt.clf()
labels = ['JDG', 'Hubert', 'Dolorès', 'Armand']
plt.bar(labels, hist)
plt.savefig("/nfs/Images/hist.png")