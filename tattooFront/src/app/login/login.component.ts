import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { FormsModule } from "@angular/forms";

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, RouterLink, FormsModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  email: string = '';
  password: string = '';


  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  login(){
    alert("logging in...");
    this.authService.login({email: this.email, password: this.password})
    .subscribe({
      next: res => {
        alert("success...");

        this.email = '';
        this.password = '';

        this.router.navigate(['/']);
      },
      
      error: err => {
        alert("error");
      }
  });

}
}
  