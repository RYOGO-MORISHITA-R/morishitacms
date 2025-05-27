from django import forms

#新規ユーザー登録用
from django.contrib.auth.forms import UserCreationForm
from .models import CustomUser

class CustomUserCreationForm(UserCreationForm):
    class Meta:
        model = CustomUser
        fields = ('username', 'password1', 'password2', 'face_image')

#ログイン用
from django.contrib.auth.forms import AuthenticationForm

class CustomLoginForm(AuthenticationForm):
    username = forms.CharField(label="ユーザー名")
    password = forms.CharField(label="パスワード", widget=forms.PasswordInput)

class FaceLoginForm(forms.Form):
    face_image = forms.ImageField(label="顔画像でログイン")
