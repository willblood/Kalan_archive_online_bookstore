@extends('layouts.app')

@section('title', 'Chat with Kalan AI')

@section('content')
    <div style="margin-top: 100px; margin-bottom: 100px;" class="container chat-container">
        <h1 class="chat-title">Chat with Kalan AI</h1>
        <div class="chat-box">
            <div id="chat-messages" class="chat-messages">
                <!-- Messages will be dynamically added here -->
            </div>
            <form id="chat-form" class="chat-form">
                @csrf
                <input type="text" id="user-input" class="chat-input" placeholder="Type your message here..." required>
                <button type="submit" class="chat-submit-btn">Send</button>
            </form>
        </div>
        <div class="chat-examples">
            <h3>Example Questions:</h3>
            <ul>
                <li class="example-question">I need a Books about programming</li>
                <li class="example-question">Recommend me some fiction books</li>
                <li class="example-question">Books for Black Hat hackers</li>
            </ul>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* General Styling */
        .chat-container {
            max-width: 800px;
            margin: 3rem auto;
            background: #f7f7f8;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .chat-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .chat-box {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .chat-messages {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            background-color: #ffffff;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .chat-message {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease-in-out;
        }

        .chat-message.user {
            justify-content: flex-end;
        }

        .chat-message.api {
            justify-content: flex-start;
        }

        .chat-message-bubble {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            word-wrap: break-word;
            font-size: 1rem;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chat-message.user .chat-message-bubble {
            background-color: rgb(12, 240, 160);
            color: #fff;
            border-bottom-right-radius: 0;
        }

        .chat-message.api .chat-message-bubble {
            background-color: #f1f1f1;
            color: #333;
            border-bottom-left-radius: 0;
        }

        .chat-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .chat-input {
            flex-grow: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .chat-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        .chat-submit-btn {
            padding: 0.75rem 1.5rem;
            background-color: rgb(8, 133, 58);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .chat-submit-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .chat-submit-btn:active {
            transform: scale(0.95);
        }

        .chat-examples {
            margin-top: 2rem;
            text-align: center;
        }

        .chat-examples h3 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .chat-examples ul {
            list-style-type: none;
            padding: 0;
        }

        .chat-examples li {
            margin-bottom: 0.5rem;
            cursor: pointer;
            color: #333;
            font-size: 1rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .chat-examples li:hover {
            color: #007bff;
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatForm = document.getElementById('chat-form');
            const userInput = document.getElementById('user-input');
            const chatMessages = document.getElementById('chat-messages');
            const exampleQuestions = document.querySelectorAll('.example-question');

            // Handle form submission
            chatForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const userMessage = userInput.value.trim();
                if (!userMessage) {
                    alert('Please enter a message.');
                    return;
                }

                // Display user message
                const userMessageElement = document.createElement('div');
                userMessageElement.classList.add('chat-message', 'user');
                userMessageElement.innerHTML = `<div class="chat-message-bubble">${userMessage}</div>`;
                chatMessages.appendChild(userMessageElement);

                // Clear input
                userInput.value = '';

                // Scroll to the bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Send message to the server
                try {
                    const response = await fetch('{{ route('ai.recommend') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ message: userMessage }),
                    });

                    const data = await response.json();

                    if (data.error) {
                        const errorMessageElement = document.createElement('div');
                        errorMessageElement.classList.add('chat-message', 'api');
                        errorMessageElement.innerHTML = `<div class="chat-message-bubble">${data.error}</div>`;
                        chatMessages.appendChild(errorMessageElement);
                        return;
                    }

                    // Display API response
                    const apiMessageElement = document.createElement('div');
                    apiMessageElement.classList.add('chat-message', 'api');
                    apiMessageElement.innerHTML = `<div class="chat-message-bubble">
        ${data.books.length > 0 ? 'Here are some recommendations:' : 'No books found.'}
        <div class="book-list">
            ${data.books.map(book => `
                <div class="book-item" style="display: flex; margin-bottom: 1rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">
                    <img src="${book.image}" alt="${book.title}" style="width: 80px; height: 120px; object-fit: cover; border-radius: 8px; margin-right: 1rem;">
                    <div style="flex-grow: 1;">
                        <a href="{{ url('books/${book.id}') }}" class="book-title" style="font-weight: bold; font-size: 1.1rem; color: #007bff; text-decoration: none;">
                            ${book.title}
                        </a>
                        <p class="book-author" style="font-size: 0.9rem; color: #555;">by ${book.author}</p>

                    </div>
                </div>
            `).join('')}
        </div>
    </div>`;
                    chatMessages.appendChild(apiMessageElement);

                    // Scroll to the bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } catch (error) {
                    console.error('Error communicating with the API:', error);
                    const errorMessageElement = document.createElement('div');
                    errorMessageElement.classList.add('chat-message', 'api');
                    errorMessageElement.innerHTML = `<div class="chat-message-bubble">An error occurred. Please try again later.</div>`;
                    chatMessages.appendChild(errorMessageElement);
                }
            });

            // Handle example question clicks
            exampleQuestions.forEach(question => {
                question.addEventListener('click', function () {
                    userInput.value = this.textContent;
                    userInput.focus();
                });
            });
        });
    </script>
@endsection
