import * as types from '../../types';

sort({});

export function sort(data: types.obj): types.obj {
    const TEST_DATA: types.obj[] = [
        {
            name: 'Joyce Byers',
            mail: 'Joyce@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Mathe',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Joyce Byers',
            mail: 'Joyce@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Deutsch',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Jim Hopper',
            mail: 'Jim@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Mike Wheeler',
            mail: 'Mike@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Biologie',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Will Byers',
            mail: 'Will@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Mathe',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Max Mayfield',
            mail: 'Max@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Steve Harrington',
            mail: 'Steve@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Biologie',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Billy Hargrove',
            mail: 'Billy@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Mathe',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Bob Newby',
            mail: 'Bob@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Chemie',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Jane Hopper',
            mail: 'Jane@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Mathe',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Dustin Henderson',
            mail: 'Dustin@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Chemie',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Eleven',
            mail: 'el@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Chemie',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Alexei',
            mail: 'alexei@gmail.com',
            giveTutoring: false, // 1
            grade: '8a',
            subject: 'Informatik',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Heather Holloway',
            mail: 'heather@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Informatik',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Larry Kline',
            mail: 'larry@gmail.com',
            giveTutoring: false, // 1
            grade: '7a',
            subject: 'Mathe',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Tom Holloway',
            mail: 'tom@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Deutsch',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },
        {
            name: 'Dr. Owens',
            mail: 'owens@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Deutsch',
            targetGrade: '0',
            single: true, //0
            time: '13',
        },

        {
            name: 'Albert Einstein',
            mail: 'albert@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Niels Bohr',
            mail: 'niels@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Nikola Tesla',
            mail: 'nikola@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Thomas Edison',
            mail: 'thomas@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Thomas Edison',
            mail: 'thomas@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Mathe',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Stephen Hawking',
            mail: 'stephen@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },
        {
            name: 'Johannes Kepler',
            mail: 'johannes@gmail.com',
            giveTutoring: false, // 1
            grade: '5a',
            subject: 'Physik',
            targetGrade: '0',
            single: false, //1
            time: '13',
        },

        {
            name: 'Lucas Sinclair',
            mail: 'Lucas@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Mathe',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Nancy Wheeler',
            mail: 'Nancy@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Chemie',
            targetGrade: '7',
            single: true, //0
            time: '13',
        },
        {
            name: 'Jonathan Byers',
            mail: 'Jonathan@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Biologie',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Karen Wheeler',
            mail: 'Karen@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Mathe',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Martin Brenner',
            mail: 'Martin@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Mathe',
            targetGrade: '7',
            single: true, //0
            time: '13',
        },
        {
            name: 'Robin Buckley',
            mail: 'Robin@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Mathe',
            targetGrade: '7',
            single: true, //0
            time: '13',
        },
        {
            name: 'Erica Sinclair',
            mail: 'Erica@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Chemie',
            targetGrade: '7',
            single: true, //0
            time: '13',
        },
        {
            name: 'Barbara Holland',
            mail: 'Barb@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Biologie',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Ross Duffer',
            mail: 'Ross@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Physik',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Matt Duffer',
            mail: 'Matt@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Physik',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'eight',
            mail: 'eight@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Physik',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Suzi',
            mail: 'suzi@gmail.com',
            giveTutoring: true, // 1
            grade: '10a',
            subject: 'Informatik',
            targetGrade: '8',
            single: true, //0
            time: '13',
        },
        {
            name: 'Murray Baumann',
            mail: 'Murray@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Informatik',
            targetGrade: '7',
            single: true, //0
            time: '13',
        },
        {
            name: 'Becky Ives',
            mail: 'becky@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Mathe',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },
        {
            name: 'Ted Wheeler',
            mail: 'ted@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Deutsch',
            targetGrade: '5',
            single: true, //0
            time: '13',
        },

        {
            name: 'Nikolaus Kopernikus',
            mail: 'nikolaus@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Physik',
            targetGrade: '5',
            single: false, //1
            time: '13',
        },
        {
            name: 'Isaac Newton',
            mail: 'isaac@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Physik',
            targetGrade: '5',
            single: false, //1
            time: '13',
        },
        {
            name: 'Ernest Rutherford',
            mail: 'ernest@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Physik',
            targetGrade: '5',
            single: false, //1
            time: '13',
        },
        {
            name: 'Galileo Galilei',
            mail: 'galileo@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Physik',
            targetGrade: '5',
            single: false, //1
            time: '13',
        },
        {
            name: 'Nikolaus Kopernikus',
            mail: 'nikolaus@gmail.com',
            giveTutoring: true, // 1
            grade: '9a',
            subject: 'Mathe',
            targetGrade: '5',
            single: false, //1
            time: '13',
        },
    ];

    let lstGiveEinzel: types.obj[] = [];
    let lstTakeEinzel: types.obj[] = [];

    let lstGiveGruppe: types.obj[] = [];
    let lstTakeGruppe: types.obj[] = [];

    // geben & nehmen + einzel & gruppe trennen
    TEST_DATA.forEach((person: types.obj) => {
        if (person.giveTutoring && person.single) {
            lstGiveEinzel.push(person);
        } else if (person.giveTutoring && !person.single) {
            lstGiveGruppe.push(person);
        } else if (!person.giveTutoring && person.single) {
            lstTakeEinzel.push(person);
        } else {
            lstTakeGruppe.push(person);
        }
    });

    let objGiveEinzel: types.obj = {
        '5': [],
        '6': [],
        '7': [],
        '8': [],
        '9': [],
        '10': [],
        '11': [],
        '12': [],
    };

    lstGiveEinzel.forEach((person: types.obj) => {
        console.log(person.grade.replace(/^[a-z]*/, ''));
        // objGiveEinzel[person.grade.replace(/[a-z]*/, '')].push(person);
    });

    // console.log(lstGiveEinzel);
    /* console.log(takeEinzel);
    console.log(giveGruppe);
    console.log(takeGruppe); */
    return {};
}
