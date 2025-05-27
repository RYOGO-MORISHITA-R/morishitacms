from django.shortcuts import render, redirect
from .forms import CustomUserCreationForm

def register(request):
    if request.method == 'POST':
        form = CustomUserCreationForm(request.POST, request.FILES)
        if form.is_valid():
            form.save()
            return redirect('login')  # ← 名前付きURLが 'login' のビューへ
    else:
        form = CustomUserCreationForm()
    return render(request, 'accounts/register.html', {'form': form})

from django.contrib.auth.views import LoginView
from .forms import CustomLoginForm

class CustomLoginView(LoginView):
    template_name = 'accounts/login.html'
    authentication_form = CustomLoginForm


from django.contrib.auth.decorators import login_required
from django.shortcuts import render, redirect
import face_recognition
import cv2
import numpy as np

@login_required
def face_verify(request):
    if request.method == 'POST':
        # base64形式で送られてくる画像データを読み取り
        import base64
        from io import BytesIO
        from PIL import Image

        image_data = request.POST.get('image')
        if not image_data:
            return render(request, 'accounts/face_verify.html', {'error': '画像が送信されていません'})

        format, imgstr = image_data.split(';base64,') 
        image_bytes = base64.b64decode(imgstr)
        pil_image = Image.open(BytesIO(image_bytes))
        img_np = np.array(pil_image)

        # 顔の照合
        user_face = face_recognition.load_image_file(request.user.face_image.path)
        user_encoding = face_recognition.face_encodings(user_face)[0]

        try:
            current_encoding = face_recognition.face_encodings(img_np)[0]
        except IndexError:
            return render(request, 'accounts/face_verify.html', {'error': '顔が検出できませんでした'})

        results = face_recognition.compare_faces([user_encoding], current_encoding)
        if results[0]:
            return redirect('/admin/chat/')
        else:
            return render(request, 'accounts/face_verify.html', {'error': '顔が一致しませんでした'})

    return render(request, 'accounts/face_verify.html')
