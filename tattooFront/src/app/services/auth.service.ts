import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/internal/Observable';
import { tap } from 'rxjs/internal/operators/tap';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'http://localhost:8000/auth';

  constructor(
    private http: HttpClient
  ){}


  register(data: {name: string, email:string, password:string, role?: string}): Observable<any> {
    return this.http.post(`${this.apiUrl}/register`, data);
  }

  login(data: {email: string, password: string}): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/login`, data).pipe (
      tap(response => {
        localStorage.setItem('token', response.token);
      })
    )
  }

  logout(): Observable<any> {
  const token = localStorage.getItem('token');
  return this.http.post<any>(`${this.apiUrl}/logout`, {}, {
    headers: { Authorization: `Bearer ${token}` }
  }).pipe(
    tap(() => {
      localStorage.removeItem('token'); // clear token locally
    })
  );
}

}
