<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">

    <!-- ── Sidebar ─────────────────────────────────────────────── -->
    <aside class="w-64 bg-navy-700 flex flex-col flex-shrink-0 shadow-xl">
      <!-- Logo -->
      <div class="px-6 py-5 border-b border-white/10">
        <RouterLink to="/" class="flex items-center gap-3 group">
          <svg class="w-8 h-8 flex-shrink-0" viewBox="0 0 40 40" fill="none">
            <circle cx="20" cy="20" r="17" stroke="#C8A45D" stroke-width="2"/>
            <ellipse cx="20" cy="20" rx="8.5" ry="17" stroke="#C8A45D" stroke-width="1.5"/>
            <line x1="3" y1="20" x2="37" y2="20" stroke="#C8A45D" stroke-width="1.5"/>
            <line x1="6" y1="12.5" x2="34" y2="12.5" stroke="#C8A45D" stroke-width="1"/>
            <line x1="6" y1="27.5" x2="34" y2="27.5" stroke="#C8A45D" stroke-width="1"/>
          </svg>
          <div class="leading-none">
            <div class="text-white text-sm font-bold tracking-widest">TRIVALO</div>
            <div class="text-gold-400 text-[9px] font-semibold tracking-[0.2em]">SOURCING</div>
          </div>
        </RouterLink>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <button
          v-for="item in navItems" :key="item.id"
          @click="setSection(item.id)"
          class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 text-left relative"
          :class="activeSection === item.id
            ? 'bg-white/15 text-white'
            : 'text-white/60 hover:text-white hover:bg-white/8'"
        >
          <component :is="item.icon" class="w-5 h-5 flex-shrink-0" />
          {{ item.label }}
          <span v-if="item.badge" class="ml-auto bg-gold-400 text-navy-800 text-xs font-bold px-1.5 py-0.5 rounded-full">
            {{ item.badge }}
          </span>
        </button>
      </nav>

      <!-- User footer -->
      <div class="px-4 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-9 h-9 rounded-full bg-gold-400 flex items-center justify-center text-navy-700 font-bold text-sm flex-shrink-0">
            {{ initials }}
          </div>
          <div class="min-w-0">
            <div class="text-white text-sm font-semibold truncate">{{ authStore.user?.name }}</div>
            <div class="text-white/40 text-xs truncate">{{ authStore.user?.email }}</div>
          </div>
        </div>
        <div class="flex gap-2">
          <RouterLink to="/profile"
            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 text-xs text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile
          </RouterLink>
          <button @click="handleLogout"
            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 text-xs text-white/60 hover:text-red-400 hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- ── Main content ────────────────────────────────────────── -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Top bar -->
      <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
          <h1 class="text-xl font-bold text-navy-700">{{ currentSection.label }}</h1>
          <p class="text-gray-400 text-xs mt-0.5">{{ currentSection.description }}</p>
        </div>
        <div class="flex items-center gap-3">
          <RouterLink to="/" class="text-xs text-gray-400 hover:text-navy-700 transition-colors flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to site
          </RouterLink>
          <button v-if="activeSection === 'requests'" @click="showNewRequest = true"
            class="btn-primary text-sm px-5 py-2">
            + New Request
          </button>
        </div>
      </header>

      <!-- Scrollable body -->
      <main class="flex-1 overflow-y-auto p-8">

        <!-- ── 1. Overview ── -->
        <div v-if="activeSection === 'overview'" class="space-y-8">
          <!-- Stats -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div v-for="stat in stats" :key="stat.label"
              class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="stat.bg">
                  <component :is="stat.icon" class="w-5 h-5" :class="stat.color" />
                </div>
              </div>
              <div class="text-3xl font-extrabold text-navy-700">{{ stat.value }}</div>
              <div class="text-gray-400 text-sm mt-1">{{ stat.label }}</div>
            </div>
          </div>

          <!-- Recent requests -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              <h2 class="font-bold text-navy-700">Recent Sourcing Requests</h2>
              <button @click="setSection('requests')" class="text-sm text-gold-500 hover:text-gold-600 font-medium">View all</button>
            </div>
            <div v-if="requests.length === 0" class="px-6 py-12 text-center text-gray-400 text-sm">No sourcing requests yet.</div>
            <div v-else>
              <div v-for="req in requests.slice(0,3)" :key="req.id"
                class="px-6 py-4 border-b border-gray-50 last:border-0 flex items-center justify-between hover:bg-gray-50 transition-colors cursor-pointer"
                @click="openRequest(req)">
                <div class="flex items-center gap-4">
                  <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </div>
                  <div>
                    <div class="font-semibold text-navy-700 text-sm">{{ req.title }}</div>
                    <div class="text-gray-400 text-xs mt-0.5">Qty: {{ req.quantity.toLocaleString() }} · {{ req.destination_country }}</div>
                  </div>
                </div>
                <StatusBadge :status="req.status" />
              </div>
            </div>
          </div>

          <!-- Pending quotes alert -->
          <div v-if="pendingQuotes.length > 0" class="bg-gold-50 border border-gold-200 rounded-2xl p-6">
            <div class="flex items-start gap-4">
              <div class="w-10 h-10 rounded-xl bg-gold-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              </div>
              <div class="flex-1">
                <div class="font-bold text-gold-800">{{ pendingQuotes.length }} quote{{ pendingQuotes.length > 1 ? 's' : '' }} awaiting your decision</div>
                <p class="text-gold-700 text-sm mt-1">Review and approve supplier quotes to move your orders forward.</p>
              </div>
              <button @click="setSection('quotes')" class="text-sm font-semibold text-gold-700 hover:text-gold-800 border border-gold-300 px-4 py-1.5 rounded-lg hover:bg-gold-100 transition-colors">
                Review Quotes
              </button>
            </div>
          </div>
        </div>

        <!-- ── 2. Sourcing Requests ── -->
        <div v-if="activeSection === 'requests'" class="space-y-4">
          <div v-if="requests.length === 0" class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="font-bold text-gray-700 mb-1">No sourcing requests yet</h3>
            <p class="text-gray-400 text-sm mb-6">Tell us what you need and we'll find the right suppliers.</p>
            <button @click="showNewRequest = true" class="btn-primary text-sm px-8">Start Your First Request</button>
          </div>

          <div v-for="req in requests" :key="req.id"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-navy-200 hover:shadow-md transition-all duration-200 cursor-pointer"
            @click="openRequest(req)">
            <div class="flex items-start justify-between gap-4">
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-2">
                  <h3 class="font-bold text-navy-700 truncate">{{ req.title }}</h3>
                  <StatusBadge :status="req.status" />
                </div>
                <p class="text-gray-500 text-sm line-clamp-2">{{ req.description }}</p>
                <div class="flex flex-wrap gap-4 mt-3 text-xs text-gray-400">
                  <span>Qty: <strong class="text-gray-600">{{ req.quantity.toLocaleString() }}</strong></span>
                  <span v-if="req.target_price">Budget: <strong class="text-gray-600">{{ req.currency }} {{ req.target_price }}/unit</strong></span>
                  <span v-if="req.destination_country">To: <strong class="text-gray-600">{{ req.destination_country }}</strong></span>
                  <span v-if="req.deadline">Deadline: <strong class="text-gray-600">{{ fmtDate(req.deadline) }}</strong></span>
                </div>
              </div>
              <div class="flex items-center gap-4 flex-shrink-0 text-xs text-gray-400">
                <div class="text-center">
                  <div class="text-lg font-bold text-navy-700">{{ req.quotes?.length || 0 }}</div>
                  <div>Quotes</div>
                </div>
                <div class="text-center">
                  <div class="text-lg font-bold text-navy-700">{{ req.documents?.length || 0 }}</div>
                  <div>Docs</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── 3. Quotes ── -->
        <div v-if="activeSection === 'quotes'" class="space-y-4">
          <div v-if="quotes.length === 0" class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <p class="text-gray-400 text-sm">No quotes received yet. Submit a sourcing request to get started.</p>
          </div>
          <div v-for="q in quotes" :key="q.id" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
              <div>
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="font-bold text-navy-700">{{ q.supplier_name }}</h3>
                  <StatusBadge :status="q.status" />
                </div>
                <p class="text-gray-400 text-xs">For: {{ q.sourcing_request?.title }}</p>
              </div>
              <div class="text-right">
                <div class="text-2xl font-extrabold text-navy-700">{{ q.currency }} {{ Number(q.unit_price).toFixed(2) }}</div>
                <div class="text-gray-400 text-xs">per unit</div>
              </div>
            </div>
            <div class="grid grid-cols-3 gap-4 py-4 border-y border-gray-100 text-sm">
              <div><div class="text-gray-400 text-xs mb-0.5">Total</div><div class="font-semibold text-navy-700">{{ q.currency }} {{ Number(q.total_price).toLocaleString() }}</div></div>
              <div><div class="text-gray-400 text-xs mb-0.5">MOQ</div><div class="font-semibold text-navy-700">{{ q.moq.toLocaleString() }} units</div></div>
              <div><div class="text-gray-400 text-xs mb-0.5">Lead Time</div><div class="font-semibold text-navy-700">{{ q.lead_time }}</div></div>
            </div>
            <p v-if="q.notes" class="text-gray-500 text-sm mt-4">{{ q.notes }}</p>
            <div v-if="q.status === 'pending'" class="flex gap-3 mt-4">
              <button @click="approveQuote(q)" class="flex-1 py-2.5 text-sm font-semibold text-white bg-green-500 rounded-xl hover:bg-green-600 transition-colors">
                Approve Quote
              </button>
              <button @click="rejectQuote(q)" class="flex-1 py-2.5 text-sm font-semibold text-red-500 border border-red-200 rounded-xl hover:bg-red-50 transition-colors">
                Reject
              </button>
            </div>
          </div>
        </div>

        <!-- ── 4. Shipments ── -->
        <div v-if="activeSection === 'shipments'" class="space-y-4">
          <div v-if="shipments.length === 0" class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <p class="text-gray-400 text-sm">No shipments yet. Shipment details will appear here once your order is confirmed.</p>
          </div>
          <div v-for="s in shipments" :key="s.id" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
              <div>
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="font-bold text-navy-700">{{ s.sourcing_request?.title }}</h3>
                  <StatusBadge :status="s.status" />
                </div>
                <div class="text-gray-400 text-xs">{{ s.carrier }} · {{ s.method === 'sea' ? 'Sea Freight' : s.method === 'air' ? 'Air Freight' : 'Express' }}</div>
              </div>
              <div v-if="s.tracking_number" class="text-right">
                <div class="text-xs text-gray-400 mb-0.5">Tracking</div>
                <div class="font-mono text-sm font-semibold text-navy-700">{{ s.tracking_number }}</div>
              </div>
            </div>

            <!-- Route visual -->
            <div class="flex items-center gap-3 my-5">
              <div class="flex-1 text-center">
                <div class="text-xs text-gray-400 mb-1">Origin</div>
                <div class="font-semibold text-navy-700 text-sm">{{ s.origin }}</div>
              </div>
              <div class="flex-1 flex flex-col items-center">
                <div class="flex items-center w-full">
                  <div class="h-px flex-1 border-t-2 border-dashed" :class="s.status === 'delivered' ? 'border-green-400' : 'border-gray-200'"></div>
                  <div class="mx-2">
                    <svg class="w-6 h-6" :class="s.status === 'delivered' ? 'text-green-500' : 'text-navy-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8zm0 0l2-5h4l2 5H13z"/></svg>
                  </div>
                  <div class="h-px flex-1 border-t-2 border-dashed" :class="s.status === 'delivered' ? 'border-green-400' : 'border-gray-200'"></div>
                </div>
                <div class="text-xs text-gray-400 mt-1">ETA {{ s.estimated_arrival ? fmtDate(s.estimated_arrival) : 'TBD' }}</div>
              </div>
              <div class="flex-1 text-center">
                <div class="text-xs text-gray-400 mb-1">Destination</div>
                <div class="font-semibold text-navy-700 text-sm">{{ s.destination }}</div>
              </div>
            </div>

            <!-- Status steps -->
            <div class="flex items-center gap-0 mt-4">
              <div v-for="(step, i) in shipmentSteps" :key="step.key" class="flex-1 flex flex-col items-center">
                <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center text-xs font-bold transition-colors"
                  :class="stepReached(s.status, step.key) ? 'bg-navy-700 border-navy-700 text-white' : 'bg-white border-gray-200 text-gray-400'">
                  <svg v-if="stepReached(s.status, step.key)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                  <span v-else>{{ i + 1 }}</span>
                </div>
                <div class="text-[10px] text-gray-400 mt-1 text-center leading-tight">{{ step.label }}</div>
                <div v-if="i < shipmentSteps.length - 1" class="absolute mt-3.5 w-full h-px bg-gray-200" style="z-index:-1"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── 5. Documents ── -->
        <div v-if="activeSection === 'documents'" class="space-y-4">
          <div v-if="documents.length === 0" class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <p class="text-gray-400 text-sm">No documents yet. Inspection reports, invoices and shipping docs will appear here.</p>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div v-for="doc in documents" :key="doc.id"
              class="flex items-center gap-4 px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition-colors">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" :class="docBg(doc.type)">
                <svg class="w-5 h-5" :class="docColor(doc.type)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
              </div>
              <div class="flex-1 min-w-0">
                <div class="font-semibold text-navy-700 text-sm truncate">{{ doc.name }}</div>
                <div class="text-gray-400 text-xs mt-0.5">{{ docTypeLabel(doc.type) }} · {{ fmtSize(doc.size) }} · {{ doc.sourcing_request?.title }}</div>
              </div>
              <div class="text-xs text-gray-400">{{ fmtDate(doc.created_at) }}</div>
              <button class="p-2 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-lg transition-colors" title="Download">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
              </button>
            </div>
          </div>
        </div>

        <!-- ── 6. Messages ── -->
        <div v-if="activeSection === 'messages'" class="flex gap-6 h-full" style="max-height: calc(100vh - 130px)">
          <!-- Request list -->
          <div class="w-72 flex-shrink-0 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-y-auto">
            <div class="px-4 py-3 border-b border-gray-100">
              <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Conversations</div>
            </div>
            <div v-if="requests.length === 0" class="p-4 text-center text-gray-400 text-sm">No requests yet.</div>
            <button v-for="req in requests" :key="req.id"
              @click="selectConversation(req)"
              class="w-full text-left px-4 py-3.5 border-b border-gray-50 last:border-0 transition-colors"
              :class="selectedRequest?.id === req.id ? 'bg-navy-50' : 'hover:bg-gray-50'">
              <div class="font-semibold text-navy-700 text-sm truncate">{{ req.title }}</div>
              <div class="flex items-center gap-2 mt-1">
                <StatusBadge :status="req.status" class="scale-90 origin-left" />
              </div>
            </button>
          </div>

          <!-- Chat area -->
          <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div v-if="!selectedRequest" class="flex-1 flex items-center justify-center text-gray-400 text-sm">
              Select a conversation to view messages
            </div>
            <template v-else>
              <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                  <h3 class="font-bold text-navy-700 text-sm">{{ selectedRequest.title }}</h3>
                  <div class="text-gray-400 text-xs mt-0.5">Trivalo Sourcing team</div>
                </div>
                <StatusBadge :status="selectedRequest.status" />
              </div>

              <!-- Messages -->
              <div class="flex-1 overflow-y-auto p-6 space-y-4" ref="messagesEl">
                <div v-if="messages.length === 0" class="text-center text-gray-400 text-sm py-8">No messages yet. Start the conversation below.</div>
                <div v-for="msg in messages" :key="msg.id"
                  class="flex gap-3"
                  :class="msg.is_from_team ? '' : 'flex-row-reverse'">
                  <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5"
                    :class="msg.is_from_team ? 'bg-navy-700 text-gold-400' : 'bg-gold-400 text-navy-700'">
                    {{ msg.is_from_team ? 'T' : initials.charAt(0) }}
                  </div>
                  <div class="max-w-[75%]">
                    <div class="text-xs text-gray-400 mb-1" :class="msg.is_from_team ? '' : 'text-right'">
                      {{ msg.is_from_team ? 'Trivalo Team' : authStore.user?.name?.split(' ')[0] }} · {{ fmtTime(msg.created_at) }}
                    </div>
                    <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed"
                      :class="msg.is_from_team
                        ? 'bg-gray-100 text-gray-700 rounded-tl-none'
                        : 'bg-navy-700 text-white rounded-tr-none'">
                      {{ msg.body }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- Input -->
              <div class="border-t border-gray-100 p-4 flex gap-3">
                <input v-model="newMessage" type="text"
                  class="flex-1 rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                  placeholder="Type your message…"
                  @keydown.enter.prevent="sendMessage">
                <button @click="sendMessage" :disabled="!newMessage.trim() || sendingMessage"
                  class="btn-primary text-sm px-5"
                  :class="{ 'opacity-50 cursor-not-allowed': !newMessage.trim() }">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
              </div>
            </template>
          </div>
        </div>

      </main>
    </div>

    <!-- ── New Request Modal ── -->
    <Transition name="fade">
      <div v-if="showNewRequest" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" @click.self="showNewRequest = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
          <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-navy-700">New Sourcing Request</h2>
            <button @click="showNewRequest = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <form @submit.prevent="submitRequest" class="px-8 py-6 space-y-5">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Title *</label>
              <input v-model="newReq.title" required type="text" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="e.g. Custom Bluetooth Earbuds">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Description *</label>
              <textarea v-model="newReq.description" required rows="3" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm resize-none" placeholder="Describe the product, specifications, materials, packaging, certifications needed…"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Quantity *</label>
                <input v-model.number="newReq.quantity" required type="number" min="1" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Price / unit</label>
                <div class="flex">
                  <select v-model="newReq.currency" class="rounded-l-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm pr-2 border-r-0">
                    <option>USD</option><option>EUR</option><option>GBP</option>
                  </select>
                  <input v-model.number="newReq.target_price" type="number" min="0" step="0.01" class="flex-1 rounded-r-xl border-gray-200 border-l-0 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="0.00">
                </div>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Destination Country</label>
                <input v-model="newReq.destination_country" type="text" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="e.g. France">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deadline</label>
                <input v-model="newReq.deadline" type="date" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Additional Notes</label>
              <textarea v-model="newReq.notes" rows="2" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm resize-none" placeholder="Any other details, restrictions, or preferences…"></textarea>
            </div>
            <div v-if="reqError" class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">{{ reqError }}</div>
            <div class="flex gap-3 pt-2">
              <button type="button" @click="showNewRequest = false" class="flex-1 py-3 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
              <button type="submit" :disabled="reqLoading" class="flex-1 btn-primary justify-center py-3 text-sm" :class="{ 'opacity-60 cursor-not-allowed': reqLoading }">
                {{ reqLoading ? 'Submitting…' : 'Submit Request' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>

    <!-- ── Request Detail Modal ── -->
    <Transition name="fade">
      <div v-if="selectedReqDetail" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" @click.self="selectedReqDetail = null">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
          <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
              <h2 class="text-lg font-bold text-navy-700">{{ selectedReqDetail.title }}</h2>
              <StatusBadge :status="selectedReqDetail.status" class="mt-1" />
            </div>
            <button @click="selectedReqDetail = null" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <div class="px-8 py-6 space-y-5 text-sm">
            <p class="text-gray-600 leading-relaxed">{{ selectedReqDetail.description }}</p>
            <div class="grid grid-cols-2 gap-4 py-4 border-y border-gray-100">
              <div><span class="text-gray-400">Quantity:</span> <strong>{{ selectedReqDetail.quantity?.toLocaleString() }}</strong></div>
              <div v-if="selectedReqDetail.target_price"><span class="text-gray-400">Target:</span> <strong>{{ selectedReqDetail.currency }} {{ selectedReqDetail.target_price }}/unit</strong></div>
              <div v-if="selectedReqDetail.destination_country"><span class="text-gray-400">Destination:</span> <strong>{{ selectedReqDetail.destination_country }}</strong></div>
              <div v-if="selectedReqDetail.deadline"><span class="text-gray-400">Deadline:</span> <strong>{{ fmtDate(selectedReqDetail.deadline) }}</strong></div>
            </div>
            <div v-if="selectedReqDetail.notes" class="bg-gray-50 rounded-xl p-4 text-gray-500">{{ selectedReqDetail.notes }}</div>
            <div class="flex gap-3 pt-2">
              <button @click="goToMessages(selectedReqDetail)" class="btn-outline text-sm px-6 py-2.5">View Messages</button>
              <button v-if="!['cancelled','delivered'].includes(selectedReqDetail.status)"
                @click="cancelRequest(selectedReqDetail)"
                class="text-sm text-red-500 border border-red-200 px-6 py-2.5 rounded-xl hover:bg-red-50 transition-colors">
                Cancel Request
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, nextTick, watch, defineComponent, h } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
const router    = useRouter()
const route     = useRoute()

if (!authStore.isAuthenticated) router.push('/auth')

const sectionIds = ['overview', 'requests', 'quotes', 'shipments', 'documents', 'messages']

function normalizeSection(section) {
  return typeof section === 'string' && sectionIds.includes(section) ? section : 'overview'
}

function setSection(section) {
  const nextSection = normalizeSection(section)
  activeSection.value = nextSection

  if (route.query.section !== nextSection) {
    router.replace({
      path: '/dashboard',
      query: nextSection === 'overview' ? {} : { section: nextSection },
    })
  }
}

// ── Icons ─────────────────────────────────────────
const mkIcon = (d) => defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d })]) })
const IconOverview   = mkIcon('M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6')
const IconSearch     = mkIcon('M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z')
const IconDoc        = mkIcon('M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z')
const IconTruck      = mkIcon('M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8zm0 0l2-5h4l2 5H13z')
const IconFolder     = mkIcon('M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z')
const IconChat       = mkIcon('M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z')

const statusMap = {
  submitted:   { label: 'Submitted',   cls: 'bg-blue-100 text-blue-700' },
  in_progress: { label: 'In Progress', cls: 'bg-yellow-100 text-yellow-700' },
  quoted:      { label: 'Quoted',      cls: 'bg-purple-100 text-purple-700' },
  confirmed:   { label: 'Confirmed',   cls: 'bg-indigo-100 text-indigo-700' },
  production:  { label: 'Production',  cls: 'bg-orange-100 text-orange-700' },
  shipped:     { label: 'Shipped',     cls: 'bg-cyan-100 text-cyan-700' },
  delivered:   { label: 'Delivered',   cls: 'bg-green-100 text-green-700' },
  cancelled:   { label: 'Cancelled',   cls: 'bg-gray-100 text-gray-500' },
  pending:     { label: 'Pending',     cls: 'bg-yellow-100 text-yellow-700' },
  approved:    { label: 'Approved',    cls: 'bg-green-100 text-green-700' },
  rejected:    { label: 'Rejected',    cls: 'bg-red-100 text-red-600' },
  in_transit:  { label: 'In Transit',  cls: 'bg-blue-100 text-blue-700' },
  customs:     { label: 'In Customs',  cls: 'bg-orange-100 text-orange-700' },
}

const StatusBadge = defineComponent({
  name: 'StatusBadge',
  props: { status: String },
  setup(props) {
    return () => {
      const s = statusMap[props.status] || { label: props.status, cls: 'bg-gray-100 text-gray-600' }
      return h('span', { class: `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold ${s.cls}` }, s.label)
    }
  }
})

// ── State ─────────────────────────────────────────
const activeSection    = ref(normalizeSection(route.query.section))
const requests         = ref([])
const quotes           = ref([])
const shipments        = ref([])
const documents        = ref([])
const messages         = ref([])
const dashStats        = ref({})
const selectedRequest  = ref(null)
const selectedReqDetail = ref(null)
const showNewRequest   = ref(false)
const newMessage       = ref('')
const sendingMessage   = ref(false)
const messagesEl       = ref(null)

const newReq = reactive({ title: '', description: '', quantity: null, target_price: null, currency: 'USD', destination_country: '', deadline: '', notes: '' })
const reqLoading = ref(false)
const reqError   = ref(null)

// ── Computed ──────────────────────────────────────
const initials = computed(() => {
  return (authStore.user?.name || '').split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
})

const pendingQuotes = computed(() => quotes.value.filter(q => q.status === 'pending'))

const navItems = computed(() => [
  { id: 'overview',  label: 'Overview',          icon: IconOverview, description: 'Your activity at a glance' },
  { id: 'requests',  label: 'Sourcing Requests',  icon: IconSearch,   description: 'Manage your product sourcing requests', badge: requests.value.filter(r => r.status === 'submitted').length || null },
  { id: 'quotes',    label: 'Quotes',             icon: IconDoc,      description: 'Review supplier quotes', badge: pendingQuotes.value.length || null },
  { id: 'shipments', label: 'Shipments',          icon: IconTruck,    description: 'Track your shipments in real-time' },
  { id: 'documents', label: 'Documents',          icon: IconFolder,   description: 'Inspection reports, invoices & more' },
  { id: 'messages',  label: 'Messages',           icon: IconChat,     description: 'Communicate with the Trivalo team' },
])

const currentSection = computed(() => navItems.value.find(n => n.id === activeSection.value) || navItems.value[0])

const stats = computed(() => [
  { label: 'Active Requests',      value: dashStats.value.active_requests    ?? 0, icon: IconSearch, bg: 'bg-blue-50',   color: 'text-blue-500' },
  { label: 'Pending Quotes',       value: dashStats.value.pending_quotes     ?? 0, icon: IconDoc,    bg: 'bg-gold-50',   color: 'text-gold-500' },
  { label: 'Shipments In Transit', value: dashStats.value.shipments_in_transit ?? 0, icon: IconTruck, bg: 'bg-purple-50', color: 'text-purple-500' },
  { label: 'Total Documents',      value: dashStats.value.total_documents    ?? 0, icon: IconFolder, bg: 'bg-green-50',  color: 'text-green-500' },
])

const shipmentSteps = [
  { key: 'pending',    label: 'Confirmed' },
  { key: 'in_transit', label: 'In Transit' },
  { key: 'customs',    label: 'Customs' },
  { key: 'delivered',  label: 'Delivered' },
]

// ── Lifecycle ─────────────────────────────────────
onMounted(async () => {
  setSection(route.query.section)
  await Promise.all([loadAll()])
})

watch(
  () => route.query.section,
  (section) => {
    const nextSection = normalizeSection(section)
    if (activeSection.value !== nextSection) {
      activeSection.value = nextSection
    }
  }
)

async function loadAll() {
  const [r, q, s, d, st] = await Promise.all([
    axios.get('/sourcing-requests'),
    axios.get('/quotes'),
    axios.get('/shipments'),
    axios.get('/documents'),
    axios.get('/dashboard/stats'),
  ])
  requests.value  = r.data
  quotes.value    = q.data
  shipments.value = s.data
  documents.value = d.data
  dashStats.value = st.data
}

// ── Actions ───────────────────────────────────────
async function handleLogout() {
  await authStore.logout()
  router.push('/')
}

async function submitRequest() {
  reqLoading.value = true
  reqError.value   = null
  try {
    const { data } = await axios.post('/sourcing-requests', newReq)
    requests.value.unshift(data)
    dashStats.value.active_requests = (dashStats.value.active_requests || 0) + 1
    dashStats.value.total_requests  = (dashStats.value.total_requests  || 0) + 1
    showNewRequest.value = false
    Object.assign(newReq, { title: '', description: '', quantity: null, target_price: null, currency: 'USD', destination_country: '', deadline: '', notes: '' })
    setSection('requests')
  } catch (e) {
    reqError.value = e?.response?.data?.message || 'Failed to submit.'
  } finally {
    reqLoading.value = false
  }
}

function openRequest(req) {
  selectedReqDetail.value = req
}

async function cancelRequest(req) {
  await axios.patch(`/sourcing-requests/${req.id}/cancel`)
  req.status = 'cancelled'
  selectedReqDetail.value = null
}

async function approveQuote(q) {
  await axios.patch(`/quotes/${q.id}/approve`)
  q.status = 'approved'
  const req = requests.value.find(r => r.id === q.sourcing_request_id)
  if (req) req.status = 'confirmed'
  dashStats.value.pending_quotes = Math.max(0, (dashStats.value.pending_quotes || 1) - 1)
}

async function rejectQuote(q) {
  await axios.patch(`/quotes/${q.id}/reject`)
  q.status = 'rejected'
  dashStats.value.pending_quotes = Math.max(0, (dashStats.value.pending_quotes || 1) - 1)
}

async function selectConversation(req) {
  selectedRequest.value = req
  const { data } = await axios.get(`/sourcing-requests/${req.id}/messages`)
  messages.value = data
  await nextTick()
  scrollMessages()
}

async function sendMessage() {
  if (!newMessage.value.trim() || sendingMessage.value) return
  sendingMessage.value = true
  try {
    const { data } = await axios.post(`/sourcing-requests/${selectedRequest.value.id}/messages`, { body: newMessage.value })
    messages.value.push(data)
    newMessage.value = ''
    await nextTick()
    scrollMessages()
  } finally {
    sendingMessage.value = false
  }
}

function scrollMessages() {
  if (messagesEl.value) messagesEl.value.scrollTop = messagesEl.value.scrollHeight
}

function goToMessages(req) {
  selectedReqDetail.value = null
  setSection('messages')
  selectConversation(req)
}

// ── Helpers ───────────────────────────────────────
function fmtDate(d) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}
function fmtTime(d) {
  if (!d) return ''
  return new Date(d).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false })
}
function fmtSize(bytes) {
  if (bytes < 1000000) return (bytes / 1000).toFixed(0) + ' KB'
  return (bytes / 1000000).toFixed(1) + ' MB'
}
function stepReached(status, step) {
  const order = ['pending', 'in_transit', 'customs', 'delivered']
  return order.indexOf(status) >= order.indexOf(step)
}
function docBg(type) {
  return { inspection_report: 'bg-blue-50', invoice: 'bg-green-50', packing_list: 'bg-purple-50', certificate_of_origin: 'bg-orange-50' }[type] || 'bg-gray-100'
}
function docColor(type) {
  return { inspection_report: 'text-blue-500', invoice: 'text-green-500', packing_list: 'text-purple-500', certificate_of_origin: 'text-orange-500' }[type] || 'text-gray-500'
}
function docTypeLabel(type) {
  return { inspection_report: 'Inspection Report', invoice: 'Invoice', packing_list: 'Packing List / BoL', certificate_of_origin: 'Certificate of Origin', other: 'Document' }[type] || type
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
