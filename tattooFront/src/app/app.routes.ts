import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    loadComponent: () =>
      import('./home/home.component').then(m => m.HomeComponent),
  },
  {
    path: 'login',
    loadComponent: () =>
      import('./login/login.component').then(m => m.LoginComponent),
  },
  {
    path: 'register',
    loadComponent: () =>
      import('./register/register.component').then(m => m.RegisterComponent),
  },
  {
    path: 'appointment',
    loadComponent: () =>
      import('./appointment/appointment.component').then(m => m.AppointmentComponent),
  },
  {
    path: 'service',
    loadComponent: () =>
      import('./service/service.component').then(m => m.ServiceComponent),
  }
];
