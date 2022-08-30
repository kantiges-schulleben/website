import * as types from '../../types';
import {
    bestMail,
    einzelLehrer,
    einzelSchueler,
    gruppeLehrer,
    gruppeSchueler,
    ohnePartner,
} from './emailTextStore';

export class emailText {
    private static texts: types.obj = {
        einzel: {
            lehrer: einzelLehrer,
            schueler: einzelSchueler,
        },
        gruppe: {
            lehrer: gruppeLehrer,
            schueler: gruppeSchueler,
        },
        ohne: { ohne: ohnePartner },
        bestMail: { bestMail: bestMail },
    };

    public static get(
        resultType: string,
        studentType: string,
        fillData: types.obj
    ): string {
        return scuffedTemplate.replace(
            this.texts[resultType][studentType],
            fillData
        );
    }
}

class scuffedTemplate {
    private static startChar: string = '{{';
    private static endChar: string = '}}';

    public static replace(template: string, data: types.obj): string {
        let output = '';
        let ref = template;

        let indexStart = -1;
        let indexEnd = -1;

        while (ref.length > 0) {
            indexStart = ref.indexOf(this.startChar) + 2;
            indexEnd = ref.indexOf(this.endChar);

            if (
                indexStart ===
                -1 + 2
                /* because 2 gets added to indexStart, so -1 becomes 1*/
            ) {
                output += ref;
                ref = '';
                break;
            }

            output += ref.substring(0, indexStart - 2);

            let key = ref.substring(indexStart, indexEnd);
            output += data[key.trim()] || this.startChar + key + this.endChar;

            ref = ref.substring(indexEnd + 2);
        }
        return output;
    }
}
