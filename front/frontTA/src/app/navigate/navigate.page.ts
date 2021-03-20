import { Component, OnInit } from '@angular/core';
//import { menuController } from 'https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/index.esm.js';
//window.menuController = menuController;
import { MenuController, NavController } from '@ionic/angular';
import { AuthService } from '../services/auth.service';


@Component({
  selector: 'app-navigate',
  templateUrl: './navigate.page.html',
  styleUrls: ['./navigate.page.scss'],
})
export class NavigatePage implements OnInit {


 constructor(
   private nav: NavController,
  private authService: AuthService) { }

  ngOnInit() {
    
  }

  getDepot(){
  this.nav.navigateForward("depot")
  }
  getRetrait(){
  this.nav.navigateForward("retrait")
  }

  getTransactions(){
  this.nav.navigateForward("/tabs/transaction")
  }
  getCalculatrice(){
  this.nav.navigateForward("/tabs/calculatrice")
  }

  logout(){
  this.authService.logout();
  }

}
