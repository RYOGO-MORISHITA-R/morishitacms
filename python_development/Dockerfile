# Python 3.11 の公式イメージを使う
FROM python:3.11

# 必要なLinuxパッケージを追加
RUN apt-get update && apt-get install -y \
    build-essential \
    cmake \
    libboost-all-dev \
    libopenblas-dev \
    liblapack-dev \
    libx11-dev \
    libgtk-3-dev \
    libglib2.0-0 \
    libsm6 \
    libxrender1 \
    libxext6 \
    libgl1-mesa-glx \
    default-libmysqlclient-dev \
    python3-dev \
    pkg-config \
    libatlas-base-dev \
    && rm -rf /var/lib/apt/lists/*

# 作業ディレクトリ
WORKDIR /app

# requirements.txt をコピーしてライブラリをインストール
COPY requirements.txt .
RUN pip install --upgrade pip
RUN pip install --no-cache-dir -r requirements.txt

# アプリのソースコードをコピー
COPY . .

# ポート開放（例: DjangoやFlaskで使用）
EXPOSE 8000
