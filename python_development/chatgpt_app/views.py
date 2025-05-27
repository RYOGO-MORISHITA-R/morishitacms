from django.shortcuts import render
from openai import OpenAI  # v1形式の読み込み

from dotenv import load_dotenv
import os

load_dotenv()
client = OpenAI()  # クライアントインスタンスを1回だけ作成

def chat_view(request):
    if request.method == "POST":
        message = request.POST.get("message")
        if not request.session.get("chat_history"):
            request.session["chat_history"] = []

        # 履歴にユーザーの発言を追加
        request.session["chat_history"].append({"role": "user", "content": message})

        # OpenAIに問い合わせ
        response = client.chat.completions.create(
            model="gpt-3.5-turbo",
            messages=request.session["chat_history"]
        )

        # 応答を履歴に追加
        reply = response.choices[0].message.content

        request.session["chat_history"].append({"role": "assistant", "content": reply})

        request.session.modified = True

        return render(request, "chatgpt_app/chat.html", {
            "chat_history": request.session["chat_history"]
        })

    # GETのときは履歴を表示
    return render(request, "chatgpt_app/chat.html", {
        "chat_history": request.session.get("chat_history", [])
    })
