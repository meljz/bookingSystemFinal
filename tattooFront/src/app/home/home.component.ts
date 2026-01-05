import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './home.component.html',
  //styleUrl: './home.component.css'
  styleUrls: ['./home.component.css']
})
export class HomeComponent {

  get userEmail(): string {
    return this.authService.isLoggedIn;
  }

  constructor(
    private router: Router,
    public authService: AuthService
  ) {}


  logout(){
    this.authService.logout()
    .subscribe({
      next: res => {
        alert("logged out successful");
        this.router.navigate(['/login']);
      },
      error: err => {
        alert("error during logout");
      }
  });
  }
}
