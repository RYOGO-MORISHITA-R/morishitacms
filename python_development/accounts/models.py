from django.contrib.auth.models import AbstractUser
from django.db import models

class CustomUser(AbstractUser):
    face_image = models.ImageField(upload_to='faces/', blank=True, null=True)
