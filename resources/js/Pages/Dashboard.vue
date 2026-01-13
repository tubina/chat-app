<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head, Link } from "@inertiajs/vue3"
import { ref } from "vue"
import { Settings, User, UserPlus, Search, Moon, PanelLeftClose, PanelRightClose, Video, Camera, Phone, EllipsisVertical, Mic, Paperclip,
    SendHorizonal, Check, CheckCheck
 } from "lucide-vue-next"

/* -----------------------------
   UI STATE
----------------------------- */
const sidebarOpen = ref(true)
const newMessage = ref("")
const activeChatId = ref(1)

/* -----------------------------
   CHATS (SIDEBAR)
----------------------------- */
const chats = ref([
  {
    id: 1,
    name: "João",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHGQIl97yWv9gCLTIejBOYaOth8bEQgFUn9w&s",
    lastMessage: "Tudo sim, e você?",
    lastMessageAt: "12:30",
    check: true,
    viewed: true,
    selected: false
  },
  {
    id: 2,
    name: "Joaquim",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTF_IdW_JHgWJh_GBrudxZXPOFfdf5598pnew&s",
    lastMessage: "falo com vocoe mais tarde 👍",
    lastMessageAt: "11:10",
    check: false,
    viewed: true,
    selected:false
  },
  {
    id: 3,
    name: "Maria",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQANCG70RHUSB3JZlRMyz96lRjwbq9mYpJEsQ&s",
    lastMessage: "vc ja viajou?",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 4,
    name: "Jose",
    avatar: "data:image/jpeg;base64,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",
    lastMessage: "me mostra o projeto",
    lastMessageAt: "11:10",
    selected:true
  },
  {
    id: 5,
    name: "Carlos",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDmOItYPOUlxHcvrJ6T8K7-EvrzX6GPCuUaA&s",
    lastMessage: "obrigado por compartilhar con...",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 6,
    name: "Joaquim",
    avatar: "data:image/jpeg;base64,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",
    lastMessage: "falo com vocoe mais tarde 👍",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 7,
    name: "Maria",
    avatar: "data:image/jpeg;base64,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",
    lastMessage: "vc ja viajou?",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 8,
    name: "Jose",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHXneaelKZA7W8UzBoTcX5CcZDlocQMAQzlE_eAnIMisfSRPN33eabxN0&s",
    lastMessage: "me mostra o projeto",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 9,
    name: "Carlos",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTHSpFf-9rt3p2rbgsWmFkxdSBrTdrd9t0pXG-d-jx50xLvBsMyfIoVlY&s",
    lastMessage: "obrigado por compartilhar con...",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 10,
    name: "Joaquim",
    avatar: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQO4eZXjcdx4ZWK4CJhysXWuNsh_fKg-Y4DDYv2H-YMjy29zAJ7zjmak9o&s",
    lastMessage: "falo com vocoe mais tarde 👍",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 11,
    name: "Maria",
    avatar: "data:image/jpeg;base64,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",
    lastMessage: "vc ja viajou?",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 12,
    name: "Jose",
    avatar: "/images/maria.jpg",
    lastMessage: "me mostra o projeto",
    lastMessageAt: "11:10",
    selected:false
  },
  {
    id: 13,
    name: "Carlos",
    avatar: "/images/maria.jpg",
    lastMessage: "obrigado por compartilhar con...",
    lastMessageAt: "11:10",
    selected:false
  },
])

/* -----------------------------
   MESSAGES (CONVERSA ATIVA)
----------------------------- */
const messages = ref([
  {
    id: 1,
    chatId: 1,
    text: "Oi, tudo bem?",
    me: false,
    avatar: "/images/joao.jpg",
  },
  {
    id: 2,
    chatId: 1,
    text: "Tudo sim, e você?",
    me: true,
    avatar: "/images/me.jpg",
  },
])

/* -----------------------------
   COMPUTED
----------------------------- */
const activeMessages = () =>
  messages.value.filter(m => m.chatId === activeChatId.value)

/* -----------------------------
   METHODS
----------------------------- */
function openChat(chatId) {
  activeChatId.value = chatId
  sidebarOpen.value = false
}

function sendMessage() {
  if (!newMessage.value) return

  messages.value.push({
    id: Date.now(),
    chatId: activeChatId.value,
    text: newMessage.value,
    me: true,
    avatar: "/images/me.jpg",
  })

  // atualiza última mensagem da sidebar
  const chat = chats.value.find(c => c.id === activeChatId.value)
  if (chat) {
    chat.lastMessage = newMessage.value
    chat.lastMessageAt = "agora"
  }

  newMessage.value = ""
}
</script>

<template>
  <Head title="Chat" />

  <AuthenticatedLayout>
    <div class="flex h-screen bg-gray-100">

      <!-- MINI SIDEBAR -->
      <aside class="flex flex-col justify-between items-center w-16 border-r bg-white py-4 space-y-4">
        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
            <Link href="/home">Logo</Link>
        </div>

        <div class="flex flex-col items-center gap-7 pb-4">
            <div><Moon class="w-5 h-5 text-gray-500" /></div>
            <div><Settings class="w-5 h-5 text-gray-500" /></div>
            <div class="border border-gray-400 rounded-full p-2"><User class="w-5 h-5 text-gray-500" /></div>
        </div>
 
      </aside>

      <!-- SIDEBAR -->
      <aside
        :class="['bg-white border-r transition-all duration-300 flex flex-col', sidebarOpen ? 'w-80' : 'w-0 overflow-hidden']"
        >
            <div class="p-4 font-bold text-lg mt-1">
                <div class="flex justify-between items-center">
                    <div class="text-gray-800">Chats</div> 
                    <UserPlus class="w-[18px] text-gray-500 
                transition-transform duration-200 hover:scale-125" /> 
                </div>
                <div class="flex items-center w-full mt-7 h-9 font-thin border-full rounded-full border border-gray-300">
                    <button><Search class="flex-0 w-4 h-4 text-gray-500 ml-5" /></button>
                    <input class="flex-1 bg-transparent border-none focus:outline-none focus:ring-0 text-[14px] text-gray-500" 
                        placeholder="find user" />
                </div>
            </div>

            <ul class="flex-1 overflow-y-auto">
                <li
                    v-for="chat in chats"
                    :key="chat.id"
                    @click="openChat(chat.id)"
                    class="flex items-center gap-3 px-4 py-[12px] hover:bg-[#f7f7f7] hover:rounded-lg cursor-pointer mx-2 my-1"
                    :class="{'bg-blue-100 border border-white rounded-lg' : chat.selected}"
                >
                    <img
                    :src="chat.avatar"
                    class="w-8 h-8 rounded-full object-cover"
                    />

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium truncate">
                            {{ chat.name }}
                            </span>
                            <span class="text-xs text-gray-400">
                            {{ chat.lastMessageAt }}
                            </span> 
                        </div>

                        <p class="flex items-center text-sm text-gray-500 truncate">
                            <div v-if="!chat.check && chat.viewed">
                                <Check class="w-3  mr-1" />
                            </div>
                            <div v-else>
                                <CheckCheck class="w-3 mr-1 text-green-700 " />
                            </div>
                            {{ chat.lastMessage }}
                        </p>
                    </div>
                </li>
            </ul>  
        </aside>

      <!-- CHAT CONTENT -->
      <main class="flex-1 flex flex-col">

        <!-- HEADER -->
        <div
          class="flex justify-between items-center px-4 gap-4 h-16 bg-white border-b  font-semibold cursor-pointer"
        > 
            <div class="flex items-center gap-3 font-medium">
                <component @click="sidebarOpen = !sidebarOpen"
                    :is="sidebarOpen ? PanelLeftClose : PanelRightClose"
                    class="w-5 text-gray-500 ml-1"
                /> 
                <img :src="chats.find(c => c.selected === true)?.avatar" class="w-9 rounded-full"/>
                {{
                    chats.find(c => c.selected === true)?.name
                }}
            </div>
            <div class="flex gap-2">
                <Phone class="w-[18px] text-gray-500 ml-5" />
                <Video class="w-[18px] text-gray-500 ml-5" />
                <Camera class="w-[18px] text-gray-500 ml-5" />
                <EllipsisVertical class="w-[18px] text-gray-500 ml-5" /> 
            </div>
        </div>

        <!-- MESSAGES -->
        <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-[#F8F9FA]">
          <div
            v-for="message in activeMessages()"
            :key="message.id"
            class="flex items-end gap-2"
            :class="message.me ? 'justify-end' : 'justify-start'"
          >
            <img
              v-if="!message.me"
              :src="message.avatar"
              class="w-8 h-8 rounded-full object-cover"
            />

            <div
              :class="[
                'max-w-xs px-4 py-2 rounded-lg text-sm shadow',
                message.me
                  ? 'bg-blue-500 text-white rounded-br-none'
                  : 'bg-gray-200 text-gray-800 rounded-bl-none'
              ]"
            >
              {{ message.text }}
            </div>

            <img
              v-if="message.me"
              :src="message.avatar"
              class="w-8 h-8 rounded-full object-cover"
            />
          </div>
        </div><!--MESSAGES END-->

        <!-- INPUT -->
        <div class="flex items-center gap-5 p-4 bg-white border-t ">
            <Mic class="w-5 h-5 ml-2 text-gray-500" />
            <input
            v-model="newMessage"
            @keyup.enter="sendMessage"
            type="text"
            placeholder="Digite sua mensagem..."
            class="flex-1 border rounded-2xl text-gray-600 px-3 py-2 focus:outline-none border-gray-300"
            />
            <Paperclip class="w-5 h-5 text-gray-500" />
            <div class="bg-blue-500 p-3 rounded-lg">
                <SendHorizonal class="w-5 h-5 text-white text-lg" />
            </div>
            <!-- <button
            @click="sendMessage"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
            Enviar
            </button> -->
        </div>

      </main>
    </div>
  </AuthenticatedLayout>
</template>