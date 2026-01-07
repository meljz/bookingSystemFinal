import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AppointmentService {
    private apiUrl = 'http://localhost:8000/appointment';

  constructor(
    private http: HttpClient
  ) { }

  bookAppointment(data: {name: string, age: number, phone: number, design: string, day: number}): Observable<any>{
    const header = { Authorization: `Bearer ${localStorage.getItem('token')}` };
    return this.http.post(`${this.apiUrl}/`, data, { headers: header });

}

  getUser(): Observable<any>{
    const header = { Authorization: `Bearer ${localStorage.getItem('token')}` };
    return this.http.get(`${this.apiUrl}/`, { headers: header });
  }

  deleteAppointment (appointmentsid: number): Observable<any>{
    const header = { Authorization: `Bearer ${localStorage.getItem('token')}` };
    return this.http.delete(`${this.apiUrl}/${appointmentsid}`, {headers: header} )
  }


}
