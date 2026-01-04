import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, RouterLink, FormsModule],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {
  name: string = '';
  email: string = '';
  password: string = '';


  constructor(
    private authService: AuthService) {}
 
  register(){
    alert("registering...");
    this.authService.register({name: this.name, email: this.email, password: this.password})
    .subscribe({
      next: res => {
        console.log("Registered", res);
        this.name = '';
        this.email = '';
        this.password = '';
        alert("success...");

      },
      error: err => {
        console.log("Error occurred during registration", err)
        alert("error");
      }
    });

  }
}
