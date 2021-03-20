import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertController, LoadingController } from '@ionic/angular';
import { DepotService } from '../services/depot.service';
import { Depot } from '../_model/depot';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit {

  segmentChang="beneficiaire";
  formRetrait: FormGroup;
  infos: any ;
  code: string;

  constructor(
    private depotService: DepotService,
    private forBuilder: FormBuilder,
    public alertController: AlertController,
    private loadingCtrl: LoadingController
    ) { }



  ngOnInit() {
    this.formRetrait= this.forBuilder.group({
      code: ['' ,Validators.required],
      cni: ['' ,Validators.required],
      type: ['retrait',Validators.required]
    })
  }


  rechercher(code:string){
    const infos = {code: code , type: 'rechercher'};
    this.code= code;

    this.depotService.depot(infos).
    subscribe((res)=>{
      this.infos = res['data'];
      //console.log(this.infos);
    },(error)=>{
      console.log(error);
    });
  }

  async onSubmit(){
    let retrait= {code: this.code, type:'retrait', cni: this.formRetrait.controls.cni.value}
    console.log(this.formRetrait.value);
    const alert= await this.alertController.create({
      header: 'Confirmer',
          message: 'voulez vous effectuer un retrait',
          buttons:[
            {
              text: 'Annuler',
              handler: () => {}
            },
            {
              text: 'OUI',
              handler: async () => {
                const loading = await this.loadingCtrl.create();
                await loading.present();
                this.depotService.depot(retrait).
                subscribe(async (data)=>{

                  await loading.dismiss();
                  const alert2 = await this.alertController.create({
                    header: 'transfert reussi',
                    subHeader: 'INFOS',
                    message: `vous avez retiré`,
                    buttons: ['OK']
                  });
                    await alert2.present();
                    this.formRetrait.reset();
                },async (error)=>{
                  console.log(error);

                  await loading.dismiss();
                  const alert2 = await this.alertController.create({
                    header: 'erreur',
                    subHeader: 'INFOS',
                    message: error.error.message,
                    buttons: ['OK']
                  });
                  await alert2.present();
                });
              }
            }
          ]
    })

    await alert.present();
  }

  showPrompt() {
    this.alertController.create({
      header: 'Confirmation',
      subHeader: 'Beneficiaire',
      message: 'fatima',

      buttons: [
        {
          text: 'annuler',
          handler: (data: any) => {
            console.log('Canceled', data);
          }
        },
        {
          text: 'confirmer!',
          handler: (data: any) => {
            console.log('Saved Information', data);
            //alert('retrait reussi');
          }
        }
      ]
    }).then(res => {
      res.present();
    });
  }

  async annulationDepot(){
    let annulation= {code: this.code, type:'annulation'};
    const alert= await this.alertController.create({
      header: 'confirmer',
        message: 'Etes-vous sur de vouloir annuler cette transaction',
        buttons: [
          {
            text: 'Annuler',
            handler: ()=>{},
          },
          {
            text:'Confirmer',
            handler: async () => {
              const loading= await this.loadingCtrl.create();
              await loading.present();
              this.depotService.depot(annulation).
              subscribe(async(data)=>{
                await loading.dismiss();
                const alert2= await this.alertController.create({
                  header: 'Annulation de transfert reussi',
                  //subHeader: 'INFOS',
                  //message: `vous avez retiré`,
                  buttons: ['Fermé']
                });
                  await alert2.present();
                  this.formRetrait.reset();
              },async (error) => {
                console.log(error);
                await loading.dismiss();

                const alert2 = await this.alertController.create({
                  header: 'Failled',
                  //subHeader: 'INFOS',
                  message: error.error.message,
                  buttons: ['Fermer']
                });
                await alert2.present();
              })
            }
          }
        ]
    })

  }
}



