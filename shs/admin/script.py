import json as json
import sys

def clearDict(dictionary):
    for key in dictionary:
        dictionary[key] = []
        pass
    return dictionary


def toList(dictionary):
    list = []
    for key in dictionary:
        list.append(dictionary[key])
        pass
    return list

def toJsonString(inputList):
    firstOrderGroups = ["einzel", "gruppe", "ohne"]

    jsonString = '{'

    for firstOrder in range(len(inputList)):
        jsonString += '"' + firstOrderGroups[firstOrder] + '":['

        if firstOrder != 2:# einzel & gruppe
            for secondOrder in range(len(inputList[firstOrder])):
                jsonString += '''{"name":"''' + inputList[firstOrder][secondOrder][0][0] + '''","mail":"''' + inputList[firstOrder][secondOrder][0][1] + '''","nachhilfe":"''' + inputList[firstOrder][secondOrder][0][2] + '''","klasse":"''' + inputList[firstOrder][secondOrder][0][3] + '''","facher":"''' + inputList[firstOrder][secondOrder][0][4] + '''","zielKlasse":"''' + inputList[firstOrder][secondOrder][0][5] + '''","einzelnachhilfe":"''' + inputList[firstOrder][secondOrder][0][6] + '''","zeit":"''' + inputList[firstOrder][secondOrder][0][7] + '''",'''


                if firstOrder == 0:# einzel
                    jsonString += '''"partner":{"name":"''' + inputList[firstOrder][secondOrder][1][0] + '''","mail":"''' + inputList[firstOrder][secondOrder][1][1] + '''","nachhilfe":"''' + inputList[firstOrder][secondOrder][1][2] + '''","klasse":"''' + inputList[firstOrder][secondOrder][1][3] + '''","facher":"''' + inputList[firstOrder][secondOrder][1][4] + '''","zielKlasse":"''' + inputList[firstOrder][secondOrder][1][5] + '''","einzelnachhilfe":"''' + inputList[firstOrder][secondOrder][1][6] + '''","zeit":"''' + inputList[firstOrder][secondOrder][1][7] + '''"}'''
                    pass
                else:# gruppe
                    jsonString += '''"anzahlPartner":"''' + str(len(inputList[firstOrder][secondOrder]) - 1) + '''","partner":{'''
                    for thirdOrder in range(len(inputList[firstOrder][secondOrder]) - 1):
                        jsonString += '''"''' + str(thirdOrder + 1) + '''":{"name":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][0] + '''","mail":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][1] + '''","nachhilfe":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][2] + '''","klasse":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][3] + '''","facher":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][4] + '''","zielKlasse":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][5] + '''","einzelnachhilfe":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][6] + '''","zeit":"''' + inputList[firstOrder][secondOrder][thirdOrder + 1][7] + '''"},'''
                        pass
                    jsonString = jsonString[:-1] + "}"
                    pass

                jsonString += '''},'''
                pass



            # "telefon":"''' + inputList[firstOrder][secondOrder][0][8] + '''",
            # "bemerkung":"''' + inputList[firstOrder][secondOrder][0][9] + '''",
            pass
        else:# ohne
            for secondOrder in range(len(inputList[firstOrder])):
                jsonString += '''{"name":"''' + inputList[firstOrder][secondOrder][0] + '''","mail":"''' + inputList[firstOrder][secondOrder][1] + '''","nachhilfe":"''' + inputList[firstOrder][secondOrder][2] + '''","klasse":"''' + inputList[firstOrder][secondOrder][3] + '''","facher":"''' + inputList[firstOrder][secondOrder][4] + '''","zielKlasse":"''' + inputList[firstOrder][secondOrder][5] + '''","einzelnachhilfe":"''' + inputList[firstOrder][secondOrder][6] + '''","zeit":"''' + inputList[firstOrder][secondOrder][7] + '''"},'''
                pass

            
            # jsonString = jsonString[:-1]
            # "telefon":"''' + inputList[firstOrder][secondOrder][8] + '''",
            # "bemerkung":"''' + inputList[firstOrder][secondOrder][9] + '''",
            pass

        jsonString = jsonString[:-1] + '],'
        pass

    jsonString = jsonString[:-1] + '}'
    return jsonString

def updateTimesIfMultipleProblems(name, timeMask, give = False, group = False):
    indexToNull = -1

    for i in range(len(timeMask)):
        if int(timeMask[i]) == 0:
            indexToNull = i
            break
            pass
        pass

    targetList = []

    if give:
        if group:
            targetList = []
            pass
        else:
            targetList = []
            pass
        pass
    else:
        if group:
            targetList = []
            pass
        else:
            targetList = []
            pass
        pass

    for person in range(len(targetList)):
        if targetList[person][4] != exclude:
            targetList[person][7][i] = "0"
            pass
        pass
    pass

# annahme: list1 = give, list2 = take
def assignByTime(list1, list2, isGroup = False, maximum = 2):
    # prüfen, ob beide oder eine list leer ist
    # wenn beide listen leer sind leere liste zurückgeben
    # wenn eine list leer ist without als andere liste setzen und zurückgeben
    if list1 == [] and list2 == []:
        return [[], []]
    elif list1 == []:
        return [list(), list(list2)]
    elif list2 == []:
        return [list(), list(list1)]

    times = len(list2[0][7])

    null = "1"

    for i in range(times - 1):
        null += "0"
        pass


    l_without = []
    l_paare = []

    temporary = []

    for time in range(1, times):
        # print(time)
        if isGroup == False:
            for i in range(len(list1)):
                if list1[i][7][time] == "1":
                    for j in range(len(list2)):
                        if list2[j][7][time] == "1":
                            l_paare.append([list(list1[i]), list(list2[j])])
                            # ===================================================
                            # print(str(list1[i]) + " => " + str(list2[j]))
                            # print(l_paare[len(l_paare) - 1])
                            # print("'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''")
                            # ===================================================
                            list2[j][7] = null
                            list1[i][7] = null

                            tmp = list(null)
                            tmp[time] = "1"

                            l_paare[len(l_paare) - 1][1][7] = "".join(tmp) # take
                            l_paare[len(l_paare) - 1][0][7] = "".join(tmp) # give
                            # ===================================================
                            # print(str(list1[i]) + " => " + str(list2[j]))
                            # print(l_paare[len(l_paare) - 1])
                            # print()
                            # ===================================================
                            break
                        pass
                    pass
                pass
            pass
        else:
            for i in range(len(list1)):
                if list1[i][7][time] == "1":
                    for count in range(maximum):
                        for j in range(len(list2)):
                            if list2[j][7][time] == "1":
                                temporary.append(list(list2[j]))
                                list2[j][7] = null
                                break
                            pass
                        pass

                    if temporary != []:
                        # TODO zuteilung wird mit anzahl 2 durchgeführt, soll variabel sein -> mit schleife
                        l_paare.append([list(list1[i]), list(temporary[0]), list(temporary[1])])
                        list1[i][7] = null

                        tmp = list(null)
                        tmp[time] = "1"

                        l_paare[len(l_paare) - 1][2][7] = "".join(tmp) # take
                        l_paare[len(l_paare) - 1][1][7] = "".join(tmp) # take
                        l_paare[len(l_paare) - 1][0][7] = "".join(tmp) # give
                        pass
                    temporary = []
                    pass
                pass
            pass
        # print("============================================")
        pass

    # ==========================================================
    for j in range(len(list1)):
        if list1[j][7] != null:
            l_without.append(list1[j])
            pass
        pass

    for j in range(len(list2)):
        if list2[j][7] != null:
            l_without.append(list2[j])
            pass
        pass
    # ==========================================================

    output = list([list(l_paare), list(l_without)])
    return output

# von 5 bis 12 nehmen
# ab 8 geben
orig_list = []

if len(sys.argv) > 1:
    if sys.argv[1].lower() == "--use-default":
        orig_list = [
        # Name,          E-Mail,             give private tutoring        grade         subject  einzelnachhilfe
        ['Joyce Byers', 'Joyce@gmail.com', '0', '5a', 'Mathematik', '0', '0', '13'],
        ['Joyce Byers', 'Joyce@gmail.com', '0', '5a', 'Deutsch', '0', '0', '13'],
        ['Jim Hopper', 'Jim@gmail.com', '0', '5a', 'Physik', '0', '0', '13'],
        ['Mike Wheeler', 'Mike@gmail.com', '0', '5a', 'Biologie', '0', '0', '13'],
        ['Will Byers', 'Will@gmail.com', '0', '5a', 'Mathematik', '0', '0', '13'],
        ['Max Mayfield', 'Max@gmail.com', '0', '5a', 'Physik', '0', '0', '13'],
        ['Steve Harrington', 'Steve@gmail.com', '0', '5a', 'Biologie', '0', '0', '13'],
        ['Billy Hargrove', 'Billy@gmail.com', '0', '7a', 'Mathematik', '0', '0', '13'],
        ['Bob Newby', 'Bob@gmail.com', '0', '7a', 'Chemie', '0', '0', '13'],
        ['Jane Hopper', 'Jane@gmail.com', '0', '7a', 'Mathematik', '0', '0', '13'],
        ['Dustin Henderson', 'Dustin@gmail.com', '0', '7a', 'Chemie', '0', '0', '13'],
        ['Eleven', 'el@gmail.com', '0', '7a', 'Chemie', '0', '0', '13'],
        ['Alexei', 'alexei@gmail.com', '0', '8a', 'Informatik', '0', '0', '13'],
        ['Heather Holloway', 'heather@gmail.com', '0', '7a', 'Informatik', '0', '0', '13'],
        ['Larry Kline', 'larry@gmail.com', '0', '7a', 'Mathematik', '0', '0', '13'],
        ['Tom Holloway', 'tom@gmail.com', '0', '5a', 'Deutsch', '0', '0', '13'],
        ['Dr. Owens', 'owens@gmail.com', '0', '5a', 'Deutsch', '0', '0', '13'],

        ['Albert Einstein', 'albert@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],
        ['Niels Bohr', 'niels@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],
        ['Nikola Tesla', 'nikola@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],
        ['Thomas Edison', 'thomas@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],
        ['Stephen Hawking', 'stephen@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],
        ['Johannes Kepler', 'johannes@gmail.com', '0', '5a', 'Physik', '0', '1', '13'],

        ['Lucas Sinclair', 'Lucas@gmail.com', '1', '10a', 'Mathematik', '5', '0', '13'],
        ['Nancy Wheeler', 'Nancy@gmail.com', '1', '10a', 'Chemie', '7', '0', '13'],
        ['Jonathan Byers', 'Jonathan@gmail.com', '1', '10a', 'Biologie', '5', '0', '13'],
        ['Karen Wheeler', 'Karen@gmail.com', '1', '10a', 'Mathematik', '5', '0', '13'],
        ['Martin Brenner', 'Martin@gmail.com', '1', '10a', 'Mathematik', '7', '0', '13'],
        ['Robin Buckley', 'Robin@gmail.com', '1', '10a', 'Mathematik', '7', '0', '13'],
        ['Erica Sinclair', 'Erica@gmail.com', '1', '10a', 'Chemie', '7', '0', '13'],
        ['Barbara Holland', 'Barb@gmail.com', '1', '10a', 'Biologie', '5', '0', '13'],
        ['Ross Duffer', 'Ross@gmail.com', '1', '10a', 'Physik', '5', '0', '13'],
        ['Matt Duffer', 'Matt@gmail.com', '1', '10a', 'Physik', '5', '0', '13'],
        ['eight', 'eight@gmail.com', '1', '10a', 'Physik', '5', '0', '13'],
        ['Suzi', 'suzi@gmail.com', '1', '10a', 'Informatik', '8', '0', '13'],
        ['Murray Baumann', 'Murray@gmail.com', '1', '9a', 'Informatik', '7', '0', '13'],
        ['Becky Ives', 'becky@gmail.com', '1', '9a', 'Mathematik', '5', '0', '13'],
        ['Ted Wheeler', 'ted@gmail.com', '1', '9a', 'Deutsch', '5', '0', '13'],

        ['Isaac Newton', 'isaac@gmail.com', '1', '9a', 'Physik', '5', '1', '13'],
        ['Ernest Rutherford', 'ernest@gmail.com', '1', '9a', 'Physik', '5', '1', '13'],
        ['Galileo Galilei', 'galileo@gmail.com', '1', '9a', 'Physik', '5', '1', '13'],
        ['Nikolaus Kopernikus', 'nikolaus@gmail.com', '1', '9a', 'Physik', '5', '1', '13']
        ]
        pass
    else:
        json_dict = json.loads(sys.argv[1])
        # Name, Klasse, Mail, Telefon, Nachhilfe, Fächer, Zeit, Einzelnachhilfe, Bemerkung, zielKlasse
        for i in range(len(json_dict)):
            tmp = []
            tmp.append(json_dict[i]['name'])
            tmp.append(json_dict[i]['mail'])
            tmp.append(json_dict[i]['nachhilfe'])
            tmp.append(json_dict[i]['llasse'])
            tmp.append(json_dict[i]['facher'])
            tmp.append(json_dict[i]['zielKlasse'])
            tmp.append(json_dict[i]['einzelnachhilfe'])
            tmp.append(json_dict[i]['zeit'])
            tmp.append(json_dict[i]['telefon'])
            tmp.append(json_dict[i]['Bemerkung'])

            orig_list.append(tmp)
            tmp = []
            pass
        pass
    pass

# =========================================================
# multi layer list
ml_list_give_einzel = []
ml_list_take_einzel = []

for person in orig_list:
    if person[2] == "0":
        person[7] = bin(int(person[7]))[2:]
        ml_list_take_einzel.append(person)
        pass
    else:
        person[7] = bin(int(person[7]))[2:]
        ml_list_give_einzel.append(person)
        pass
    pass

# =========================================================
ml_list_give_gruppe = []

tmp = []

for person in ml_list_give_einzel:
    if person[6] == '1':
        ml_list_give_gruppe.append(person)
        pass
    else:
        tmp.append(person)
        pass
    pass

ml_list_give_einzel = tmp
NumberOfTutors_Gruppe = len(ml_list_give_gruppe)

# =========================================================
ml_list_take_gruppe = []

tmp = []

for person in ml_list_take_einzel:
    if person[6] == '1':
        ml_list_take_gruppe.append(person)
        pass
    else:
        tmp.append(person)
        pass
    pass

ml_list_take_einzel = tmp
# NumberOfStudents_Gruppe = len(ml_list_take_gruppe)
# =========================================================

grade = 5

tmp_list = []
tmp_ml_list = []

# sort by grade
while grade <= 12:
    for i in ml_list_give_einzel:
        if i[5] == str(grade):
            tmp_list.append(i)
            pass
        pass
    tmp_ml_list.append(tmp_list)
    tmp_list = []
    grade += 1
pass
ml_list_give_einzel = tmp_ml_list
# =========================================================
grade = 5

tmp_list = []
tmp_ml_list = []

# sort by grade
while grade <= 12:
    for i in ml_list_take_einzel:
        if i[3][:-1] == str(grade):
            tmp_list.append(i)
            pass
        pass
    tmp_ml_list.append(tmp_list)
    tmp_list = []
    grade += 1
pass
ml_list_take_einzel = tmp_ml_list

# =========================================================

grade = 5

tmp_list = []
tmp_ml_list = []

# sort by grade
while grade <= 12:
    for i in ml_list_give_gruppe:
        if i[5] == str(grade):
            tmp_list.append(i)
            pass
        pass
    tmp_ml_list.append(tmp_list)
    tmp_list = []
    grade += 1
pass
ml_list_give_gruppe = tmp_ml_list
# =========================================================
grade = 5

tmp_list = []
tmp_ml_list = []

# sort by grade
while grade <= 12:
    for i in ml_list_take_gruppe:
        if i[3][:-1] == str(grade):
            tmp_list.append(i)
            pass
        pass
    tmp_ml_list.append(tmp_list)
    tmp_list = []
    grade += 1
pass
ml_list_take_gruppe = tmp_ml_list
# ==============================================================================================================================

# sort by subject

subjects = {"Mathematik": [], "Physik": [], "Chemie": [], "Biologie": [], "Informatik": [], "Deutsch": [
], "Englisch": [], "Franzosisch": [], "Russisch": [], "Geschichte": [], "Geografie": [], "GRW": []}

NumberOfSubjects = len(subjects)

tmp_list = []

for grade in ml_list_take_einzel:
    for person in grade:
        subjects[person[4]].append(person)
        pass
    tmp_list.append(toList(subjects))
    clearDict(subjects)
    pass

ml_list_take_einzel = tmp_list


tmp_list = []
for grade in ml_list_give_einzel:
    for person in grade:
        subjects[person[4]].append(person)
        pass
    tmp_list.append(toList(subjects))
    clearDict(subjects)
    pass

ml_list_give_einzel = tmp_list

# ==================================================================

tmp_list = []

for grade in ml_list_take_gruppe:
    for person in grade:
        subjects[person[4]].append(person)
        pass
    tmp_list.append(toList(subjects))
    clearDict(subjects)
    pass

ml_list_take_gruppe = tmp_list


tmp_list = []
for grade in ml_list_give_gruppe:
    for person in grade:
        subjects[person[4]].append(person)
        pass
    tmp_list.append(toList(subjects))
    clearDict(subjects)
    pass

ml_list_give_gruppe = tmp_list

# ==============================================================================================================================

grade = 5

without = []
paare = []

while grade < 12:
    for j in range(NumberOfSubjects):
        give = []
        take = []

        give = ml_list_give_einzel[grade - 5][j]
        take = ml_list_take_einzel[grade - 5][j]

        output = assignByTime(give, take) # 0 = paare, 1 = without
        paare.extend(output[0])
        without.extend(output[1])

        pass
    grade += 1
    pass

# ==============================================================================================================================

maximum = 2
current = 0

grade = 5

paare_group = []

tutors = []
students = []

current = 0
start = 0

# gruppen
while grade < 12:
    for j in range(NumberOfSubjects):
        current = 0
        give = []
        take = []

        give = ml_list_give_gruppe[grade - 5][j]
        take = ml_list_take_gruppe[grade - 5][j]

        output = assignByTime(give, take, True, maximum)
        paare_group.extend(output[0])
        without.extend(output[1])
    grade += 1
    pass

# ====================================================================================================================================
actualOutput = []

actualOutput.append(list(paare))
actualOutput.append(list(paare_group))
actualOutput.append(list(without))

# ====================================================================================================================================
print(toJsonString(actualOutput))