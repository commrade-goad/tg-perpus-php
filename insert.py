import csv
import requests

def login(api_url, username, password):
    session = requests.Session()
    login_url = f"{api_url}"
    credentials = {"id": username, "password": password}
    
    response = session.post(login_url, json=credentials)
    
    if response.status_code == 200:
        print("Login successful.")
        return session
    else:
        print(f"Login failed. Status code: {response.status_code}, Response: {response.text}")
        return None

def read_csv_to_dict(file_path):
    books = []
    with open(file_path, mode='r', encoding='utf-8') as csv_file:
        reader = csv.DictReader(csv_file)
        for row in reader:
            # Ensure all required fields are present
            book = {
                "title": row.get("title", "").strip(),
                "author": row.get("author", "").strip(),
                "desc": row.get("desc", "").strip(),
                "tags": row.get("tags", "").strip(),
                "year": row.get("year", "").strip(),
                "img": ""
            }
            books.append(book)
    return books

# Function to send POST requests
def send_books_to_api(api_url, books):
    for book in books:
        response = requests.post(api_url, json=book)
        if response.status_code == 200:
            print(f"Book '{book['title']}' added successfully.")
        else:
            print(f"Failed to add book '{book['title']}'. Status code: {response.status_code}, Response: {response.text}")

# Main function
if __name__ == "__main__":
    csv_file_path = "./books.csv"
    api_endpoint = "http://localhost:8081/api/add_book"
    login("http://localhost:8081/api/auth_user", "0", "U0FZQSBBRE1JTgo=")
    books_data = read_csv_to_dict(csv_file_path)
    send_books_to_api(api_endpoint, books_data)
