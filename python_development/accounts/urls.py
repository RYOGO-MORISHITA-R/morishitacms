from django.urls import path
from django.contrib.auth import views as auth_views
from . import views
from .forms import CustomLoginForm
from .views import face_verify

urlpatterns = [
    path('register/', views.register, name='register'),
    path('login/', auth_views.LoginView.as_view(
        template_name='accounts/login.html',
        authentication_form=CustomLoginForm
    ), name='login'),
    path('face-verify/', views.face_verify, name='face_verify'),
]
