import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../services/auth.service';
import { AppointmentService } from '../services/appointment.service';

@Component({
  selector: 'app-appointment',
  imports: [CommonModule, RouterLink, FormsModule],
  templateUrl: './appointment.component.html',
  styleUrl: './appointment.component.css'
})
export class AppointmentComponent {
  days = Array.from({ length: 31 }, (_, i) => i + 1);
  months = Array.from({ length: 12 }, (_, i) => i + 1);
  years = Array.from({ length: 5 }, (_, i) => new Date().getFullYear() + i);

  selectedDate: string = '';
  selectedDay: number | null = null;

  //form fields
    name = '';
    age = '';
    phone = '';
    design = '';


  //hiding currently
  bAppoint = false;

  constructor(
    private router: Router,
    public authService: AuthService,
    private appointmentService: AppointmentService) { }

  bookAppointment() {
    this.bAppoint = true;
    this.selectedDay = null;
  }

  cancelBooking(){
    this.bAppoint = false;
  }

  confirmBooking() {
    alert('check message 1 confirming 1');
    this.bAppoint = false;

    this.appointmentService.bookAppointment({ name: this.name, age: Number(this.age), phone: Number(this.phone), design: this.design, date: this.selectedDate })
    .subscribe({
      next: res => {
        alert('Appointment booked successfully!');
          //reset form fields
        this.name = '';
        this.age = '';
        this.phone = '';
        this.design = '';
      },
      error: err => {
        alert('Error booking appointment. Please try again.');
      }
    })
   


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