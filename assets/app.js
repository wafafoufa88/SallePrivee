/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


//-------------------calculate---------//
const   calculateForm =document.getElementById('calculate-form'),
        calculateCm = document.getElementById('calculate-cm'),
        calculateKg = document.getElementById('calculate-kg'),
        calculateMessage = document.getElementById('calculate-message')
const calculateBmi = (e) =>{
    e.preventDefault()
    if(calculateCm.value ==='' || calculateKg.value ===''){
        calculateMessage.classList.remove('color-green')
        calculateMessage.classList.add('color-red')//ajouter la couleur
        calculateMessage.textContent = 'remplissez la taille et le poids'//pour affiche le message 
        setTimeout(() =>{//pour faire disparaitre le message aprés quelque seconde quand u appuie
            calculateMessage.textContent =''
        },3000)
    } else{
        //Bmi formule
            const cm = calculateCm.value / 100,
                kg = calculateKg.value, 
                bmi = Math.round(kg /(cm * cm))
    
                //montrez votre statut de santé
                if(bmi < 18.5){
                    calculateMessage.classList.add('color-green')
                    calculateMessage.textContent = `Votre BMI est ${bmi} vous êtes maigre`
                }else if(bmi < 25){
                    calculateMessage.classList.add('color-green')
                    calculateMessage.textContent = `Votre BMI est ${bmi} vous êtes en bon santé`
                }else{
                    calculateMessage.classList.add('color-green')
                    calculateMessage.textContent = `Votre BMI est ${bmi} vous êtes en surpoids `
                }
                calculateCm.value=''
                calculateKg.value=''
                
                setTimeout(() =>{
                    calculateMessage.textContent =''
                },4000)


            }
            }
 
calculateForm.addEventListener('submit',calculateBmi)

/*-----------------------------*/
/*------------------------------carousel---------- */

/*------------------------------------*/