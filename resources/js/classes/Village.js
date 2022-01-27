export class Village {

    static allFromReligiousZone(villageName){
        console.log(villageName);
        let vilg = document.getElementById(villageName);
        let zone = vilg.className.split(' ')[1];
        return document.querySelectorAll('.'+zone);
    }

    static addIcon(villageName, card){
        let icon;
        if(card == 'Bonne Récolte' || card == 'Beau Temps'){
            icon = '<i class="fas fa-sun"></i>';
        }
        document.querySelector(`#${villageName}>.icons`).innerHTML += icon
    }

    static disaster(villageName, disaster){

        let icon;
        if(disaster === 'Famine'){
            icon = 'water';
        }else if(disaster === 'Mauvais Temps'){
            icon = 'snowflake';
        }else if(disaster === 'Peste'){
            icon === 'skull-crossbones'
        }

        let isHere = false;
        document.querySelectorAll(`#${villageName}>.icons>i`).forEach(el=>{
            if(el.className.includes('fa-'+icon)){
                isHere = document.querySelector(`#${villageName}>.icons>.fa-${icon}`);
            }
        })
        return isHere;
    }

}
