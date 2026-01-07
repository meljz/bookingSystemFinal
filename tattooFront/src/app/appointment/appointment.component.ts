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

  selectedDate: Date | null = null;
  selectedDay: number | null = null;

  //empty fields
  appointments: any[] = [];

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

  bookAppointment(day:number) {
    this.selectedDay = day;
    this.bAppoint = true;
    this.selectedDate = new Date(2026, 0, day);

  }

  ngOnInit(): void {
    //try to retain booked appointment
  }


  cancelBooking(){
    this.bAppoint = false;
  }

  confirmBooking() {
    alert('check message 1 confirming 1');
    this.bAppoint = false;

    this.appointmentService.bookAppointment({ name: this.name, age: Number(this.age), phone: Number(this.phone), design: this.design, day: Number(this.selectedDay) })
    .subscribe({
      next: res => {
        alert('Appointment booked successfully!');
        // ensure appointment appears on the clicked day in the calendar view
        const appt = res.appointment || {};
        if (this.selectedDay != null) {
          const now = new Date();
          const localDate = new Date(now.getFullYear(), now.getMonth(), Number(this.selectedDay));
          appt.created_at = localDate.toISOString();
        }
        this.appointments.push(appt);
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

  deleteAppointment(appointmentId: number) {
    this.appointmentService.deleteAppointment(appointmentId)
    .subscribe ({
      next: res => {
        alert ('successfully deleted appointment');
        this.getUser(); //this will fetch everything again.
        console.log(res);
      },
      error: err => {
        alert('Error deleting appointment.');
      }
    });
  }

  editAppointment(appointmentId: number) {
    //IN PROGRESS
  }

  getUser() {
    this.appointmentService.getUser()
    .subscribe({
      next: res => {
        console.log ('getting user data');
        this.appointments = res.appointments;
        console.log(res);
      },
      error: err => {
        alert('Error retrieving user data.');
      }
    })
  }

  getAppointmentsForDay(day: number) {
  const now = new Date();
  const year = now.getFullYear();
  const month = now.getMonth();
  return this.appointments.filter(appt => {
    const apptDate = new Date(appt.created_at);
    return apptDate.getFullYear() === year && apptDate.getMonth() === month && apptDate.getDate() === day;
  });
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