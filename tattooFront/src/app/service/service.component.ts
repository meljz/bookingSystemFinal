import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink, Router} from '@angular/router';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-service',
  imports: [CommonModule, RouterLink],
  templateUrl: './service.component.html',
  styleUrl: './service.component.css'
})
export class ServiceComponent {

  constructor(
    private router: Router, 
    public authService: AuthService) {
    
  }

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
