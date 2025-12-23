import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';

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

  constructor(private router: Router) { }

  bookAppointment() {
    this.bAppoint = true;
    this.selectedDay = null;
  }


  cancelBooking(){
    this.bAppoint = false;
  }

  confirmBooking() {
    // Here you can handle the booking logic, e.g., send data to a server
    console.log('Booking confirmed for:', this.name, this.age, this.phone, this.design, 'on', this.selectedDate);
    this.bAppoint = false;
    alert('Booking confirmed!');

    //reset form fields
    this.name = '';
    this.age = '';
    this.phone = '';
    this.design = '';
  }
}