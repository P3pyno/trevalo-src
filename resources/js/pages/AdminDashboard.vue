<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">

    <!-- ── Sidebar ─────────────────────────────────────────────── -->
    <aside class="w-64 bg-navy-700 flex flex-col flex-shrink-0 shadow-xl">
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
            <div class="text-gold-400 text-[9px] font-semibold tracking-[0.2em]">ADMIN</div>
          </div>
        </RouterLink>
      </div>

      <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <button
          v-for="item in navItems" :key="item.id"
          @click="activeSection = item.id"
          class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 text-left"
          :class="activeSection === item.id ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/8'"
        >
          <component :is="item.icon" class="w-5 h-5 flex-shrink-0" />
          {{ item.label }}
          <span v-if="item.badge" class="ml-auto bg-gold-400 text-navy-800 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ item.badge }}</span>
        </button>
      </nav>

      <div class="px-4 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-9 h-9 rounded-full bg-gold-400 flex items-center justify-center text-navy-700 font-bold text-sm flex-shrink-0">{{ initials }}</div>
          <div class="min-w-0">
            <div class="flex items-center gap-2">
              <div class="text-white text-sm font-semibold truncate">{{ authStore.user?.name }}</div>
              <span class="text-[9px] font-bold bg-gold-400 text-navy-800 px-1.5 py-0.5 rounded-full flex-shrink-0">ADMIN</span>
            </div>
            <div class="text-white/40 text-xs truncate">{{ authStore.user?.email }}</div>
          </div>
        </div>
        <div class="flex gap-2">
          <RouterLink to="/dashboard"
            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 text-xs text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            My Dashboard
          </RouterLink>
          <button @click="handleLogout"
            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 text-xs text-white/60 hover:text-red-400 hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- ── Main ─────────────────────────────────────────────────── -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
          <h1 class="text-xl font-bold text-navy-700">{{ currentSection.label }}</h1>
          <p class="text-gray-400 text-xs mt-0.5">{{ currentSection.description }}</p>
        </div>
        <RouterLink to="/" class="text-xs text-gray-400 hover:text-navy-700 transition-colors flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Back to site
        </RouterLink>
      </header>

      <main class="flex-1 overflow-y-auto p-8">

        <!-- ── Overview ─────────────────────────────────────────── -->
        <section v-if="activeSection === 'overview'">
          <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="text-xs text-gray-400 font-medium mb-1">Total Users</div>
              <div class="text-3xl font-bold text-navy-700">{{ stats.total_users ?? '—' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="text-xs text-gray-400 font-medium mb-1">Total Requests</div>
              <div class="text-3xl font-bold text-navy-700">{{ stats.total_requests ?? '—' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="text-xs text-gray-400 font-medium mb-1">Open Requests</div>
              <div class="text-3xl font-bold text-gold-500">{{ stats.open_requests ?? '—' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="text-xs text-gray-400 font-medium mb-1">Pending Quotes</div>
              <div class="text-3xl font-bold text-navy-700">{{ stats.pending_quotes ?? '—' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="text-xs text-gray-400 font-medium mb-1">Active Shipments</div>
              <div class="text-3xl font-bold text-navy-700">{{ stats.active_shipments ?? '—' }}</div>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Requests by status -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
              <h3 class="text-sm font-semibold text-navy-700 mb-4">Requests by Status</h3>
              <div v-if="stats.requests_by_status" class="space-y-2.5">
                <div v-for="(count, status) in stats.requests_by_status" :key="status" class="flex items-center gap-3">
                  <StatusBadge :status="status" />
                  <div class="flex-1 bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full bg-navy-500 transition-all"
                      :style="{ width: stats.total_requests ? (count / stats.total_requests * 100) + '%' : '0%' }"></div>
                  </div>
                  <span class="text-xs font-semibold text-gray-500 w-5 text-right">{{ count }}</span>
                </div>
              </div>
            </div>

            <!-- Recent requests -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
              <h3 class="text-sm font-semibold text-navy-700 mb-4">Recent Requests</h3>
              <div class="space-y-3">
                <div v-for="r in stats.recent_requests" :key="r.id"
                  class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 rounded-xl px-2 py-1.5 transition-colors"
                  @click="activeSection = 'requests'; requestFilter = ''">
                  <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-navy-700 truncate">{{ r.title }}</div>
                    <div class="text-xs text-gray-400">{{ r.user?.name }} · {{ fmtDate(r.created_at) }}</div>
                  </div>
                  <StatusBadge :status="r.status" />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- ── Requests ──────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'requests'">
          <div class="flex items-center gap-3 mb-6">
            <select v-model="requestFilter"
              class="text-sm border border-gray-200 rounded-xl px-3 py-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-navy-400">
              <option value="">All statuses</option>
              <option v-for="s in REQUEST_STATUSES" :key="s" :value="s">{{ fmtStatus(s) }}</option>
            </select>
            <span class="text-xs text-gray-400">{{ filteredRequests.length }} request{{ filteredRequests.length !== 1 ? 's' : '' }}</span>
          </div>

          <div class="space-y-3">
            <div v-for="req in filteredRequests" :key="req.id"
              class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 cursor-pointer hover:shadow-md transition-shadow"
              @click="openRequestDetail(req)">
              <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-sm font-semibold text-navy-700 truncate">{{ req.title }}</span>
                    <StatusBadge :status="req.status" />
                  </div>
                  <div class="text-xs text-gray-400">
                    <span class="font-medium text-gray-500">{{ req.user?.name }}</span>
                    <span class="mx-1">·</span>{{ req.user?.email }}
                  </div>
                </div>
                <div class="text-right flex-shrink-0 text-xs text-gray-400">
                  <div>{{ req.quotes_count }} quote{{ req.quotes_count !== 1 ? 's' : '' }}</div>
                  <div>{{ fmtDate(req.created_at) }}</div>
                </div>
              </div>
              <div class="flex gap-4 mt-3 text-xs text-gray-500">
                <span v-if="req.quantity">Qty: <strong>{{ req.quantity }}</strong></span>
                <span v-if="req.destination_country">Dest: <strong>{{ req.destination_country }}</strong></span>
                <span v-if="req.target_price">Budget: <strong>{{ req.currency }} {{ req.target_price }}</strong></span>
                <span v-if="req.deadline">Deadline: <strong>{{ fmtDate(req.deadline) }}</strong></span>
              </div>
            </div>
            <div v-if="!filteredRequests.length" class="text-center py-12 text-gray-400 text-sm">No requests found.</div>
          </div>
        </section>

        <!-- ── Quotes ────────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'quotes'">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <select v-model="quoteRequestFilter"
                class="text-sm border border-gray-200 rounded-xl px-3 py-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-navy-400">
                <option :value="null">All requests</option>
                <option v-for="r in allRequests" :key="r.id" :value="r.id">{{ r.title }}</option>
              </select>
            </div>
            <button @click="openQuoteModal(null)"
              class="btn-primary text-sm">
              + New Quote
            </button>
          </div>

          <div class="space-y-3">
            <div v-for="q in filteredQuotes" :key="q.id" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-sm font-semibold text-navy-700">{{ q.supplier_name }}</span>
                    <QuoteStatusBadge :status="q.status" />
                  </div>
                  <div class="text-xs text-gray-400">
                    For: <span class="font-medium text-gray-600">{{ q.sourcing_request?.title }}</span>
                    <span class="mx-1">·</span>{{ q.sourcing_request?.user?.name }}
                  </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                  <button @click="openQuoteModal(q)"
                    class="p-1.5 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  </button>
                  <button v-if="deletingQuoteId !== q.id" @click="deletingQuoteId = q.id"
                    class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                  <template v-else>
                    <button @click="deleteQuote(q.id)" class="text-xs text-red-500 font-medium hover:text-red-600 px-2 py-1 bg-red-50 rounded-lg">Confirm</button>
                    <button @click="deletingQuoteId = null" class="text-xs text-gray-400 hover:text-gray-600 px-2 py-1 bg-gray-100 rounded-lg">Cancel</button>
                  </template>
                </div>
              </div>
              <div class="grid grid-cols-4 gap-4 mt-3 text-xs">
                <div><div class="text-gray-400">Unit Price</div><div class="font-semibold text-navy-700">{{ q.currency }} {{ q.unit_price }}</div></div>
                <div><div class="text-gray-400">Total Price</div><div class="font-semibold text-navy-700">{{ q.currency }} {{ q.total_price }}</div></div>
                <div><div class="text-gray-400">MOQ</div><div class="font-semibold text-navy-700">{{ q.moq }} units</div></div>
                <div><div class="text-gray-400">Lead Time</div><div class="font-semibold text-navy-700">{{ q.lead_time }}</div></div>
              </div>
              <div v-if="q.notes" class="mt-2 text-xs text-gray-500 italic">{{ q.notes }}</div>
            </div>
            <div v-if="!filteredQuotes.length" class="text-center py-12 text-gray-400 text-sm">No quotes found.</div>
          </div>
        </section>

        <!-- ── Shipments ─────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'shipments'">
          <div class="flex items-center justify-between mb-6">
            <select v-model="shipmentFilter"
              class="text-sm border border-gray-200 rounded-xl px-3 py-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-navy-400">
              <option value="">All statuses</option>
              <option value="pending">Pending</option>
              <option value="in_transit">In Transit</option>
              <option value="customs">Customs</option>
              <option value="delivered">Delivered</option>
            </select>
            <button @click="openShipmentModal(null)" class="btn-primary text-sm">+ New Shipment</button>
          </div>

          <div class="space-y-4">
            <div v-for="s in filteredShipments" :key="s.id" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">

              <!-- Header -->
              <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-sm font-semibold text-navy-700">{{ s.sourcing_request?.title || 'Unknown Request' }}</span>
                    <ShipmentStatusBadge :status="s.status" />
                  </div>
                  <div class="text-xs text-gray-400">
                    <span class="font-medium text-gray-500">{{ s.sourcing_request?.user?.name }}</span>
                    <span class="mx-1">·</span>
                    <span>{{ s.carrier || 'Carrier TBD' }}</span>
                    <span class="mx-1">·</span>
                    <span>{{ { sea: 'Sea Freight', air: 'Air Freight', express: 'Express' }[s.method] }}</span>
                  </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                  <div v-if="s.tracking_number" class="text-right">
                    <div class="text-[10px] text-gray-400 mb-0.5">Tracking</div>
                    <div class="flex items-center gap-1.5 justify-end">
                      <span class="font-mono text-xs font-semibold text-navy-700">{{ s.tracking_number }}</span>
                      <button @click="navigator?.clipboard?.writeText(s.tracking_number)"
                        class="p-1 text-gray-400 hover:text-navy-700 rounded transition-colors" title="Copy">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                      </button>
                    </div>
                  </div>
                  <button @click="openShipmentModal(s)"
                    class="p-1.5 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  </button>
                </div>
              </div>

              <!-- Route visual -->
              <div class="flex items-center gap-2 my-3 px-2">
                <div class="flex-1 text-center">
                  <div class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Origin</div>
                  <div class="font-semibold text-navy-700 text-xs">{{ s.origin }}</div>
                </div>
                <div class="flex-1 flex flex-col items-center">
                  <div class="flex items-center w-full">
                    <div class="h-px flex-1 border-t-2 border-dashed transition-colors"
                      :class="s.status !== 'pending' ? 'border-navy-400' : 'border-gray-200'"></div>
                    <div class="mx-3 flex-shrink-0">
                      <svg v-if="s.method === 'air'" class="w-5 h-5 transition-colors"
                        :class="s.status !== 'pending' ? 'text-navy-600' : 'text-gray-300'"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                      </svg>
                      <svg v-else-if="s.method === 'sea'" class="w-5 h-5 transition-colors"
                        :class="s.status !== 'pending' ? 'text-navy-600' : 'text-gray-300'"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17c1.5 1 4.5 1 6 0s4.5-1 6 0 4.5 1 6 0M5 17l2-7h10l2 7M10 10V7h4v3"/>
                      </svg>
                      <svg v-else class="w-5 h-5 transition-colors"
                        :class="s.status !== 'pending' ? 'text-navy-600' : 'text-gray-300'"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8zm0 0l2-5h4l2 5H13z"/>
                      </svg>
                    </div>
                    <div class="h-px flex-1 border-t-2 border-dashed transition-colors"
                      :class="s.status === 'delivered' ? 'border-navy-400' : 'border-gray-200'"></div>
                  </div>
                  <div class="text-[10px] text-gray-400 mt-1">ETA: <strong class="text-gray-600">{{ s.estimated_arrival ? fmtDate(s.estimated_arrival) : 'TBD' }}</strong></div>
                </div>
                <div class="flex-1 text-center">
                  <div class="text-[10px] text-gray-400 mb-1 uppercase tracking-wide">Destination</div>
                  <div class="font-semibold text-navy-700 text-xs">{{ s.destination }}</div>
                </div>
              </div>

              <!-- Progress steps (fixed connector) -->
              <div class="relative flex items-start mt-4 pt-1">
                <div class="absolute left-0 right-0 top-3.5 h-px bg-gray-200"></div>
                <div v-for="(step, i) in [{ key:'pending', label:'Confirmed' }, { key:'in_transit', label:'In Transit' }, { key:'customs', label:'Customs' }, { key:'delivered', label:'Delivered' }]"
                  :key="step.key" class="flex-1 flex flex-col items-center relative">
                  <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center text-xs font-bold transition-all duration-300 bg-white"
                    :class="adminStepReached(s.status, step.key) ? 'bg-navy-700 border-navy-700 text-white' : 'border-gray-200 text-gray-300'">
                    <svg v-if="adminStepReached(s.status, step.key)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span v-else class="text-[10px]">{{ i + 1 }}</span>
                  </div>
                  <div class="text-[10px] mt-1.5 text-center leading-tight px-1"
                    :class="adminStepReached(s.status, step.key) ? 'text-navy-700 font-semibold' : 'text-gray-400'">
                    {{ step.label }}
                  </div>
                </div>
              </div>

            </div>
            <div v-if="!filteredShipments.length" class="text-center py-12 text-gray-400 text-sm">No shipments found.</div>
          </div>
        </section>

        <!-- ── Users ─────────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'users'">
          <div class="mb-6">
            <input v-model="userSearch" type="text" placeholder="Search by name or email…"
              class="text-sm border border-gray-200 rounded-xl px-4 py-2 w-80 focus:outline-none focus:ring-2 focus:ring-navy-400" />
          </div>

          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-gray-100 text-xs text-gray-400 font-medium">
                  <th class="text-left px-6 py-3">User</th>
                  <th class="text-left px-4 py-3">Company</th>
                  <th class="text-left px-4 py-3">Country</th>
                  <th class="text-center px-4 py-3">Requests</th>
                  <th class="text-left px-4 py-3">Joined</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="u in paginatedUsers" :key="u.id">
                  <tr class="border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition-colors"
                    @click="expandedUser = expandedUser === u.id ? null : u.id">
                    <td class="px-6 py-3">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-navy-100 flex items-center justify-center text-navy-700 font-bold text-xs flex-shrink-0">
                          {{ u.name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase() }}
                        </div>
                        <div>
                          <div class="flex items-center gap-2">
                            <span class="font-medium text-navy-700">{{ u.name }}</span>
                            <span v-if="u.is_admin" class="text-[9px] font-bold bg-gold-400 text-navy-800 px-1.5 py-0.5 rounded-full">ADMIN</span>
                          </div>
                          <div class="text-xs text-gray-400">{{ u.email }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ u.company || '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ u.country || '—' }}</td>
                    <td class="px-4 py-3 text-center">
                      <span class="text-navy-700 font-semibold">{{ u.sourcing_requests_count }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ fmtDate(u.created_at) }}</td>
                  </tr>
                  <!-- Expanded row -->
                  <tr v-if="expandedUser === u.id" class="bg-gray-50">
                    <td colspan="5" class="px-6 py-4">
                      <UserDetail :user-id="u.id" />
                    </td>
                  </tr>
                </template>
                <tr v-if="!paginatedUsers.length">
                  <td colspan="5" class="text-center py-12 text-gray-400">No users found.</td>
                </tr>
              </tbody>
            </table>
            <!-- Pagination -->
            <div v-if="allUsers.length > USER_PAGE_SIZE" class="flex items-center justify-between px-6 py-3 border-t border-gray-100">
              <span class="text-xs text-gray-400">{{ filteredUsers.length }} users</span>
              <div class="flex gap-2">
                <button :disabled="userPage === 1" @click="userPage--"
                  class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-500 disabled:opacity-40 hover:bg-gray-50 transition-colors">Prev</button>
                <span class="px-3 py-1 text-xs text-gray-500">{{ userPage }} / {{ totalUserPages }}</span>
                <button :disabled="userPage >= totalUserPages" @click="userPage++"
                  class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-500 disabled:opacity-40 hover:bg-gray-50 transition-colors">Next</button>
              </div>
            </div>
          </div>
        </section>

        <!-- ── Documents ─────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'documents'" class="flex gap-6 h-full -m-8">
          <!-- Request search panel -->
          <div class="w-80 bg-white border-r border-gray-100 flex flex-col flex-shrink-0">
            <div class="px-6 py-4 border-b border-gray-100">
              <h3 class="text-sm font-semibold text-navy-700 mb-3">Find by Product or Company</h3>
              <input v-model="docRequestSearch" type="text" placeholder="Search…"
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
            </div>
            <div class="flex-1 overflow-y-auto">
              <div v-if="filteredDocRequests.length === 0" class="p-4 text-center text-gray-400 text-xs">
                {{ docRequestSearch ? 'No requests found' : 'Start typing to search…' }}
              </div>
              <button v-for="req in filteredDocRequests" :key="req.id"
                @click="selectedDocRequest = req"
                class="w-full text-left px-6 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors"
                :class="selectedDocRequest?.id === req.id ? 'bg-navy-50' : ''">
                <div class="font-medium text-navy-700 text-sm truncate">{{ req.title }}</div>
                <div class="text-xs text-gray-400 mt-0.5">
                  <span class="font-medium text-gray-500">{{ req.user?.name }}</span>
                  <span class="mx-1">·</span>
                  <span>{{ req.user?.company || 'No company' }}</span>
                </div>
                <div class="text-xs text-gray-400 mt-1">{{ selectedDocRequests(req.id).length }} document{{ selectedDocRequests(req.id).length !== 1 ? 's' : '' }}</div>
              </button>
            </div>
          </div>

          <!-- Documents panel -->
          <div class="flex-1 flex flex-col">
            <div class="px-8 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
              <div>
                <h3 v-if="selectedDocRequest" class="text-sm font-semibold text-navy-700">{{ selectedDocRequest.title }}</h3>
                <p v-if="selectedDocRequest" class="text-xs text-gray-400 mt-0.5">
                  <span class="font-medium text-gray-500">{{ selectedDocRequest.user?.name }}</span>
                  <span class="mx-1">·</span>{{ selectedDocRequest.user?.company || 'No company' }}
                </p>
                <p v-else class="text-sm text-gray-400">Select a product to view documents</p>
              </div>
              <button v-if="selectedDocRequest" @click="adminDocForm.sourcing_request_id = selectedDocRequest.id; showAdminDocUpload = true" class="btn-primary text-xs py-2">+ Upload</button>
            </div>

            <div v-if="!selectedDocRequest" class="flex-1 flex items-center justify-center text-gray-400 text-sm">
              Select a product from the list to view its documents
            </div>

            <div v-else-if="selectedDocRequests(selectedDocRequest.id).length === 0" class="flex-1 flex items-center justify-center">
              <div class="text-center">
                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 text-sm">No documents for this product yet.</p>
              </div>
            </div>

            <div v-else class="flex-1 overflow-y-auto px-8 py-4 space-y-2">
              <div v-for="doc in selectedDocRequests(selectedDocRequest.id)" :key="doc.id"
                class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="w-10 h-10 rounded-lg bg-navy-50 flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="font-medium text-navy-700 text-sm truncate">{{ doc.name }}</div>
                  <div class="text-gray-400 text-xs mt-0.5">{{ docTypeLabel(doc.type) }} · {{ fmtSize(doc.size) }}</div>
                </div>
                <div class="text-xs text-gray-400 flex-shrink-0">{{ fmtDate(doc.created_at) }}</div>
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <a v-if="doc.url" :href="doc.url" target="_blank"
                    class="p-1.5 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-lg transition-colors" title="View">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  </a>
                  <a v-if="doc.url" :href="doc.url" download
                    class="p-1.5 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-lg transition-colors" title="Download">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                  </a>
                  <button @click="deleteAdminDoc(doc)" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- ── Messages ──────────────────────────────────────────── -->
        <section v-else-if="activeSection === 'messages'" class="h-full -m-8">
          <div class="flex h-full">
            <!-- Thread list -->
            <div class="w-72 border-r border-gray-100 bg-white flex flex-col flex-shrink-0">
              <div class="px-4 py-3 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-navy-700">Conversations</h3>
              </div>
              <div class="flex-1 overflow-y-auto">
                <button
                  v-for="thread in messageThreads" :key="thread.id"
                  @click="selectThread(thread)"
                  class="w-full text-left px-4 py-3 border-b border-gray-50 transition-colors hover:bg-gray-50"
                  :class="selectedThread?.id === thread.id ? 'bg-navy-50 border-l-2 border-l-navy-500' : ''">
                  <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-navy-700 truncate">{{ thread.title }}</span>
                    <span class="text-[10px] text-gray-400 flex-shrink-0 ml-2">{{ fmtTime(thread.updated_at) }}</span>
                  </div>
                  <div class="text-xs text-gray-400 truncate">{{ thread.user?.name }}</div>
                  <div v-if="thread.messages?.[0]" class="text-xs text-gray-400 truncate mt-0.5">
                    {{ thread.messages[0].is_from_team ? 'You: ' : '' }}{{ thread.messages[0].body }}
                  </div>
                </button>
                <div v-if="!messageThreads.length" class="text-center py-12 text-gray-400 text-xs">No conversations yet.</div>
              </div>
            </div>

            <!-- Chat pane -->
            <div class="flex-1 flex flex-col bg-gray-50">
              <template v-if="selectedThread">
                <div class="px-6 py-4 bg-white border-b border-gray-100 flex-shrink-0">
                  <div class="font-semibold text-navy-700 text-sm">{{ selectedThread.title }}</div>
                  <div class="text-xs text-gray-400">{{ selectedThread.user?.name }} · {{ selectedThread.user?.email }}</div>
                </div>

                <div ref="chatEl" class="flex-1 overflow-y-auto px-6 py-4 space-y-3">
                  <div v-for="msg in messages" :key="msg.id" class="flex" :class="msg.is_from_team ? 'justify-end' : 'justify-start'">
                    <div class="max-w-sm px-4 py-2.5 rounded-2xl text-sm shadow-sm space-y-1.5"
                      :class="msg.is_from_team ? 'bg-navy-700 text-white rounded-br-sm' : 'bg-white text-gray-700 rounded-bl-sm'">
                      <div class="text-[10px] mb-1 opacity-60">{{ msg.is_from_team ? 'Team' : msg.user?.name }}</div>
                      <p v-if="msg.body">{{ msg.body }}</p>
                      <a v-if="msg.attachment_path && isImage(msg.attachment_mime)"
                        :href="msg.attachment_path" target="_blank">
                        <img :src="msg.attachment_path" :alt="msg.attachment_name"
                          class="max-w-[180px] rounded-lg border border-white/20 cursor-pointer hover:opacity-90 transition-opacity mt-1">
                      </a>
                      <a v-else-if="msg.attachment_path"
                        :href="msg.attachment_path" target="_blank" download
                        class="flex items-center gap-1.5 underline underline-offset-2 opacity-80 hover:opacity-100 text-xs">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        {{ msg.attachment_name }}
                      </a>
                    </div>
                  </div>
                  <div v-if="!messages.length" class="text-center py-8 text-gray-400 text-xs">No messages yet.</div>
                </div>

                <div class="px-6 py-4 bg-white border-t border-gray-100 flex-shrink-0 space-y-2">
                  <div v-if="adminChatFile" class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-xs text-gray-600">
                    <svg class="w-3.5 h-3.5 text-navy-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span class="flex-1 truncate">{{ adminChatFile.name }}</span>
                    <button @click="adminChatFile = null; adminChatFileInput && (adminChatFileInput.value = '')" class="text-gray-400 hover:text-red-500">×</button>
                  </div>
                  <div class="flex gap-3">
                    <input ref="adminChatFileInput" type="file" class="hidden" @change="adminChatFile = $event.target.files[0]">
                    <button type="button" @click="adminChatFileInput.click()"
                      class="p-2 text-gray-400 hover:text-navy-700 hover:bg-gray-100 rounded-xl transition-colors flex-shrink-0" title="Attach file">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </button>
                    <input v-model="newMessage" @keydown.enter.prevent="sendMessage"
                      type="text" placeholder="Reply as team…"
                      class="flex-1 text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy-400" />
                    <button @click="sendMessage" :disabled="!newMessage.trim() && !adminChatFile"
                      class="btn-primary text-sm disabled:opacity-40">Send</button>
                  </div>
                </div>
              </template>
              <div v-else class="flex-1 flex items-center justify-center text-gray-400 text-sm">
                Select a conversation to view messages.
              </div>
            </div>
          </div>
        </section>

      </main>
    </div>

    <!-- ── Request Detail Modal ──────────────────────────────────── -->
    <Transition name="fade">
      <div v-if="selectedRequest" class="fixed inset-0 bg-black/40 z-40 flex items-start justify-end p-4" @click.self="selectedRequest = null">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg h-full overflow-y-auto">
          <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold text-navy-700">Request Detail</h2>
            <button @click="selectedRequest = null" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <div class="flex items-center gap-2 mb-1">
                <h3 class="font-semibold text-navy-700">{{ selectedRequest.title }}</h3>
                <StatusBadge :status="selectedRequest.status" />
              </div>
              <p class="text-xs text-gray-500">{{ selectedRequest.user?.name }} ({{ selectedRequest.user?.email }})</p>
            </div>

            <div v-if="selectedRequest.description" class="text-sm text-gray-600 bg-gray-50 rounded-xl p-4">{{ selectedRequest.description }}</div>

            <div class="grid grid-cols-2 gap-3 text-xs">
              <div><span class="text-gray-400">Quantity:</span> <strong>{{ selectedRequest.quantity }}</strong></div>
              <div><span class="text-gray-400">Currency:</span> <strong>{{ selectedRequest.currency }}</strong></div>
              <div><span class="text-gray-400">Target Price:</span> <strong>{{ selectedRequest.target_price || '—' }}</strong></div>
              <div><span class="text-gray-400">Destination:</span> <strong>{{ selectedRequest.destination_country || '—' }}</strong></div>
              <div><span class="text-gray-400">Deadline:</span> <strong>{{ selectedRequest.deadline ? fmtDate(selectedRequest.deadline) : '—' }}</strong></div>
              <div><span class="text-gray-400">Created:</span> <strong>{{ fmtDate(selectedRequest.created_at) }}</strong></div>
            </div>

            <div v-if="selectedRequest.notes" class="text-xs text-gray-500 bg-yellow-50 rounded-xl p-3">{{ selectedRequest.notes }}</div>

            <!-- Change status -->
            <div class="border-t border-gray-100 pt-4">
              <label class="text-xs font-medium text-gray-500 mb-2 block">Change Status</label>
              <div class="flex gap-2">
                <select v-model="newStatus"
                  class="flex-1 text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                  <option v-for="s in REQUEST_STATUSES" :key="s" :value="s">{{ fmtStatus(s) }}</option>
                </select>
                <button @click="saveStatus" :disabled="savingStatus || newStatus === selectedRequest.status"
                  class="btn-primary text-sm disabled:opacity-40">
                  {{ savingStatus ? 'Saving…' : 'Save' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- ── Quote Modal ───────────────────────────────────────────── -->
    <Transition name="fade">
      <div v-if="showQuoteModal" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center p-4" @click.self="showQuoteModal = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
          <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold text-navy-700">{{ editingQuote ? 'Edit Quote' : 'New Quote' }}</h2>
            <button @click="showQuoteModal = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <form @submit.prevent="saveQuote" class="p-6 space-y-4">
            <div v-if="!editingQuote">
              <label class="block text-xs font-medium text-gray-500 mb-1">Sourcing Request</label>
              <select v-model="quoteForm.sourcing_request_id" required
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                <option :value="null" disabled>Select a request…</option>
                <option v-for="r in allRequests" :key="r.id" :value="r.id">{{ r.title }} ({{ r.user?.name }})</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-500 mb-1">Supplier Name</label>
              <input v-model="quoteForm.supplier_name" required type="text"
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
            </div>
            <div class="grid grid-cols-3 gap-3">
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Unit Price</label>
                <input v-model="quoteForm.unit_price" required type="number" step="0.01" min="0"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Total Price</label>
                <input v-model="quoteForm.total_price" required type="number" step="0.01" min="0"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Currency</label>
                <select v-model="quoteForm.currency" required
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                  <option>USD</option><option>EUR</option><option>CNY</option><option>GBP</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">MOQ (units)</label>
                <input v-model="quoteForm.moq" required type="number" min="1"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Lead Time</label>
                <input v-model="quoteForm.lead_time" required type="text" placeholder="e.g. 30 days"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-500 mb-1">Notes</label>
              <textarea v-model="quoteForm.notes" rows="3"
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400 resize-none" />
            </div>
            <div v-if="quoteFormError" class="text-xs text-red-500 bg-red-50 rounded-xl px-3 py-2">{{ quoteFormError }}</div>
            <div class="flex gap-3 pt-2">
              <button type="button" @click="showQuoteModal = false"
                class="flex-1 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
              <button type="submit" :disabled="savingQuote"
                class="flex-1 btn-primary text-sm disabled:opacity-40">{{ savingQuote ? 'Saving…' : (editingQuote ? 'Update' : 'Create') }}</button>
            </div>
          </form>
        </div>
      </div>
    </Transition>

    <!-- ── Shipment Modal ────────────────────────────────────────── -->
    <Transition name="fade">
      <div v-if="showShipmentModal" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center p-4" @click.self="showShipmentModal = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
          <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold text-navy-700">{{ editingShipment ? 'Edit Shipment' : 'New Shipment' }}</h2>
            <button @click="showShipmentModal = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <form @submit.prevent="saveShipment" class="p-6 space-y-4">
            <div v-if="!editingShipment">
              <label class="block text-xs font-medium text-gray-500 mb-1">Sourcing Request</label>
              <select v-model="shipmentForm.sourcing_request_id" required
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                <option :value="null" disabled>Select a request…</option>
                <option v-for="r in allRequests" :key="r.id" :value="r.id">{{ r.title }} ({{ r.user?.name }})</option>
              </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tracking Number</label>
                <input v-model="shipmentForm.tracking_number" type="text"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Carrier</label>
                <input v-model="shipmentForm.carrier" type="text"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Origin</label>
                <input v-model="shipmentForm.origin" type="text" placeholder="Guangzhou, China"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Destination *</label>
                <input v-model="shipmentForm.destination" required type="text"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Method *</label>
                <select v-model="shipmentForm.method" required
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                  <option value="sea">Sea</option>
                  <option value="air">Air</option>
                  <option value="express">Express</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select v-model="shipmentForm.status"
                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400">
                  <option value="pending">Pending</option>
                  <option value="in_transit">In Transit</option>
                  <option value="customs">Customs</option>
                  <option value="delivered">Delivered</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-500 mb-1">Estimated Arrival</label>
              <input v-model="shipmentForm.estimated_arrival" type="date"
                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-400" />
            </div>
            <div v-if="shipmentFormError" class="text-xs text-red-500 bg-red-50 rounded-xl px-3 py-2">{{ shipmentFormError }}</div>
            <div class="flex gap-3 pt-2">
              <button type="button" @click="showShipmentModal = false"
                class="flex-1 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
              <button type="submit" :disabled="savingShipment"
                class="flex-1 btn-primary text-sm disabled:opacity-40">{{ savingShipment ? 'Saving…' : (editingShipment ? 'Update' : 'Create') }}</button>
            </div>
          </form>
        </div>
      </div>
    </Transition>

    <!-- ── Admin Document Upload Modal ──────────────────────────── -->
    <Transition name="fade">
      <div v-if="showAdminDocUpload" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center p-4" @click.self="showAdminDocUpload = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
          <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-navy-700">Upload Document</h2>
            <button @click="showAdminDocUpload = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <form @submit.prevent="submitAdminDocUpload" class="px-8 py-6 space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Related Request *</label>
              <select v-model="adminDocForm.sourcing_request_id" required class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
                <option value="" disabled>Select a sourcing request…</option>
                <option v-for="req in allRequests" :key="req.id" :value="req.id">{{ req.title }} — {{ req.user?.name }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Document Type *</label>
              <select v-model="adminDocForm.type" required class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
                <option v-for="t in DOC_TYPES" :key="t.value" :value="t.value">{{ t.label }}</option>
              </select>
            </div>
            <div v-if="adminDocForm.type === 'other'">
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Specify Type</label>
              <input v-model="adminDocForm.custom_type" type="text" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="e.g. Supplier Agreement">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Document Name <span class="text-gray-400 font-normal">(optional)</span></label>
              <input v-model="adminDocForm.name" type="text" class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm" placeholder="Leave blank to use file name">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">File *</label>
              <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-navy-400 transition-colors"
                @click="$refs.adminDocFileInput.click()">
                <input ref="adminDocFileInput" type="file" class="hidden"
                  accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp"
                  @change="adminDocForm.file = $event.target.files[0]">
                <div v-if="!adminDocForm.file" class="py-2">
                  <svg class="w-7 h-7 text-gray-300 mx-auto mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                  <p class="text-xs text-gray-400">Click to select file (PDF, Word, Excel, images)</p>
                </div>
                <div v-else class="flex items-center gap-2 justify-center text-sm text-navy-700 font-medium">
                  <svg class="w-5 h-5 text-navy-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                  {{ adminDocForm.file.name }}
                  <button type="button" @click.stop="adminDocForm.file = null" class="text-gray-400 hover:text-red-500 ml-1">×</button>
                </div>
              </div>
            </div>
            <div v-if="adminDocUploadError" class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">{{ adminDocUploadError }}</div>
            <div class="flex gap-3 pt-2">
              <button type="button" @click="showAdminDocUpload = false" class="flex-1 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
              <button type="submit" :disabled="adminDocUploadLoading || !adminDocForm.file || !adminDocForm.sourcing_request_id"
                class="flex-1 btn-primary text-sm disabled:opacity-40">
                {{ adminDocUploadLoading ? 'Uploading…' : 'Upload' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>

  </div>
</template>

<script setup>
import { ref, reactive, computed, nextTick, defineComponent, h, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'

const authStore = useAuthStore()
const router    = useRouter()

const initials = computed(() => {
  const name = authStore.user?.name || ''
  return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
})

async function handleLogout() {
  await authStore.logout()
  router.push('/')
}

// ── Icons ────────────────────────────────────────────────────────
function mkIcon(d) {
  return defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d })]) })
}
const IconOverview   = mkIcon('M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z')
const IconRequests   = mkIcon('M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2')
const IconQuotes     = mkIcon('M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z')
const IconShipments  = mkIcon('M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4')
const IconUsers      = mkIcon('M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z')
const IconDocuments  = mkIcon('M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z')
const IconMessages   = mkIcon('M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z')

// ── Nav items ───────────────────────────────────────────────────
const activeSection = ref('overview')
const navItems = computed(() => [
  { id: 'overview',   label: 'Overview',   icon: IconOverview,  description: 'Platform statistics', badge: null },
  { id: 'requests',   label: 'Requests',   icon: IconRequests,  description: 'All sourcing requests', badge: allRequests.value.filter(r => r.status === 'submitted').length || null },
  { id: 'quotes',     label: 'Quotes',     icon: IconQuotes,    description: 'Manage quotes', badge: allQuotes.value.filter(q => q.status === 'pending').length || null },
  { id: 'shipments',  label: 'Shipments',  icon: IconShipments, description: 'Track shipments', badge: null },
  { id: 'users',      label: 'Users',      icon: IconUsers,     description: 'Registered users', badge: null },
  { id: 'documents',  label: 'Documents',  icon: IconDocuments, description: 'Manage client documents', badge: null },
  { id: 'messages',   label: 'Messages',   icon: IconMessages,  description: 'Client conversations', badge: null },
])

const currentSection = computed(() => {
  const item = navItems.value.find(i => i.id === activeSection.value)
  return { label: item?.label || '', description: item?.description || '' }
})

// ── Constants ───────────────────────────────────────────────────
const REQUEST_STATUSES = ['submitted', 'in_progress', 'quoted', 'confirmed', 'production', 'shipped', 'delivered', 'cancelled']
const USER_PAGE_SIZE = 15

// ── Formatters ──────────────────────────────────────────────────
function fmtDate(d) { return d ? new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '—' }
function fmtTime(d) { if (!d) return ''; const now = Date.now(); const diff = now - new Date(d); if (diff < 86400000) return new Date(d).toLocaleTimeString('en', { hour: '2-digit', minute: '2-digit' }); return fmtDate(d) }
function fmtStatus(s) { return s.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) }

// ── Status badges ───────────────────────────────────────────────
const STATUS_COLORS = {
  submitted: 'bg-blue-100 text-blue-700',
  in_progress: 'bg-purple-100 text-purple-700',
  quoted: 'bg-yellow-100 text-yellow-700',
  confirmed: 'bg-indigo-100 text-indigo-700',
  production: 'bg-orange-100 text-orange-700',
  shipped: 'bg-cyan-100 text-cyan-700',
  delivered: 'bg-green-100 text-green-700',
  cancelled: 'bg-gray-100 text-gray-500',
}
const StatusBadge = defineComponent({
  props: ['status'],
  render() {
    const cls = STATUS_COLORS[this.status] || 'bg-gray-100 text-gray-500'
    return h('span', { class: `inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold ${cls}` }, fmtStatus(this.status || ''))
  }
})

const QUOTE_STATUS_COLORS = { pending: 'bg-yellow-100 text-yellow-700', approved: 'bg-green-100 text-green-700', rejected: 'bg-red-100 text-red-700' }
const QuoteStatusBadge = defineComponent({
  props: ['status'],
  render() {
    const cls = QUOTE_STATUS_COLORS[this.status] || 'bg-gray-100 text-gray-500'
    return h('span', { class: `inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold ${cls}` }, fmtStatus(this.status || ''))
  }
})

const SHIP_STATUS_COLORS = { pending: 'bg-gray-100 text-gray-500', in_transit: 'bg-blue-100 text-blue-700', customs: 'bg-orange-100 text-orange-700', delivered: 'bg-green-100 text-green-700' }
const ShipmentStatusBadge = defineComponent({
  props: ['status'],
  render() {
    const cls = SHIP_STATUS_COLORS[this.status] || 'bg-gray-100 text-gray-500'
    return h('span', { class: `inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold ${cls}` }, fmtStatus(this.status || ''))
  }
})

// ── Data ────────────────────────────────────────────────────────
const stats          = ref({})
const allRequests    = ref([])
const allQuotes      = ref([])
const allShipments   = ref([])
const allUsers       = ref([])
const messageThreads = ref([])
const messages       = ref([])
const selectedThread = ref(null)
const chatEl         = ref(null)
const newMessage     = ref('')
const adminChatFile  = ref(null)
const adminChatFileInput = ref(null)

// Documents
const allDocuments    = ref([])
const adminDocSection = ref('all')
const showAdminDocUpload = ref(false)
const adminDocUploadLoading = ref(false)
const adminDocUploadError   = ref(null)
const adminDocForm = reactive({ sourcing_request_id: '', type: 'contract', custom_type: '', name: '', file: null })
const docRequestSearch = ref('')
const selectedDocRequest = ref(null)
const DOC_TYPES = [
  { value: 'contract',              label: 'Contract' },
  { value: 'license',               label: 'License' },
  { value: 'inspection_report',     label: 'Inspection Report' },
  { value: 'invoice',               label: 'Invoice' },
  { value: 'packing_list',          label: 'Packing List / BoL' },
  { value: 'certificate_of_origin', label: 'Certificate of Origin' },
  { value: 'other',                 label: 'Other (specify)' },
]

// ── Filters ─────────────────────────────────────────────────────
const requestFilter     = ref('')
const quoteRequestFilter = ref(null)
const shipmentFilter    = ref('')
const userSearch        = ref('')
const userPage          = ref(1)
const expandedUser      = ref(null)

const filteredRequests = computed(() =>
  allRequests.value.filter(r => !requestFilter.value || r.status === requestFilter.value)
)
const filteredQuotes = computed(() =>
  allQuotes.value.filter(q => !quoteRequestFilter.value || q.sourcing_request_id === quoteRequestFilter.value)
)
const filteredShipments = computed(() =>
  allShipments.value.filter(s => !shipmentFilter.value || s.status === shipmentFilter.value)
)
const filteredUsers = computed(() => {
  const q = userSearch.value.toLowerCase()
  return allUsers.value.filter(u => !q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q))
})
const totalUserPages = computed(() => Math.ceil(filteredUsers.value.length / USER_PAGE_SIZE))
const paginatedUsers = computed(() => filteredUsers.value.slice((userPage.value - 1) * USER_PAGE_SIZE, userPage.value * USER_PAGE_SIZE))

const filteredDocRequests = computed(() => {
  const q = docRequestSearch.value.toLowerCase()
  if (!q) return allRequests.value
  return allRequests.value.filter(r => 
    r.title.toLowerCase().includes(q) || 
    r.user?.name?.toLowerCase().includes(q) ||
    r.user?.company?.toLowerCase().includes(q)
  )
})

function selectedDocRequests(requestId) {
  return allDocuments.value.filter(d => d.sourcing_request_id === requestId)
}

// ── Request detail modal ────────────────────────────────────────
const selectedRequest = ref(null)
const newStatus       = ref('')
const savingStatus    = ref(false)

async function openRequestDetail(req) {
  const { data } = await axios.get(`/admin/sourcing-requests/${req.id}`)
  selectedRequest.value = data
  newStatus.value = data.status
}

async function saveStatus() {
  savingStatus.value = true
  try {
    const { data } = await axios.patch(`/admin/sourcing-requests/${selectedRequest.value.id}/status`, { status: newStatus.value })
    selectedRequest.value.status = data.status
    const idx = allRequests.value.findIndex(r => r.id === data.id)
    if (idx !== -1) allRequests.value[idx].status = data.status
  } finally {
    savingStatus.value = false
  }
}

// ── Quote modal ─────────────────────────────────────────────────
const showQuoteModal  = ref(false)
const editingQuote    = ref(null)
const savingQuote     = ref(false)
const quoteFormError  = ref('')
const deletingQuoteId = ref(null)

const quoteFormDefaults = () => ({ sourcing_request_id: null, supplier_name: '', unit_price: '', total_price: '', currency: 'USD', moq: '', lead_time: '', notes: '' })
const quoteForm = ref(quoteFormDefaults())

function openQuoteModal(q) {
  editingQuote.value = q
  quoteFormError.value = ''
  quoteForm.value = q
    ? { supplier_name: q.supplier_name, unit_price: q.unit_price, total_price: q.total_price, currency: q.currency, moq: q.moq, lead_time: q.lead_time, notes: q.notes || '' }
    : quoteFormDefaults()
  showQuoteModal.value = true
}

async function saveQuote() {
  savingQuote.value = true
  quoteFormError.value = ''
  try {
    if (editingQuote.value) {
      const { data } = await axios.put(`/admin/quotes/${editingQuote.value.id}`, quoteForm.value)
      const idx = allQuotes.value.findIndex(q => q.id === data.id)
      if (idx !== -1) allQuotes.value[idx] = { ...allQuotes.value[idx], ...data }
    } else {
      const { data } = await axios.post('/admin/quotes', quoteForm.value)
      allQuotes.value.unshift(data)
    }
    showQuoteModal.value = false
  } catch (err) {
    quoteFormError.value = err?.response?.data?.message || 'Failed to save quote.'
  } finally {
    savingQuote.value = false
  }
}

async function deleteQuote(id) {
  await axios.delete(`/admin/quotes/${id}`)
  allQuotes.value = allQuotes.value.filter(q => q.id !== id)
  deletingQuoteId.value = null
}

// ── Shipment modal ──────────────────────────────────────────────
const showShipmentModal  = ref(false)
const editingShipment    = ref(null)
const savingShipment     = ref(false)
const shipmentFormError  = ref('')

const shipmentFormDefaults = () => ({ sourcing_request_id: null, tracking_number: '', carrier: '', origin: 'Guangzhou, China', destination: '', method: 'sea', status: 'pending', estimated_arrival: '' })
const shipmentForm = ref(shipmentFormDefaults())

function openShipmentModal(s) {
  editingShipment.value = s
  shipmentFormError.value = ''
  shipmentForm.value = s
    ? { tracking_number: s.tracking_number || '', carrier: s.carrier || '', origin: s.origin, destination: s.destination, method: s.method, status: s.status, estimated_arrival: s.estimated_arrival || '' }
    : shipmentFormDefaults()
  showShipmentModal.value = true
}

async function saveShipment() {
  savingShipment.value = true
  shipmentFormError.value = ''
  try {
    if (editingShipment.value) {
      const { data } = await axios.put(`/admin/shipments/${editingShipment.value.id}`, shipmentForm.value)
      const idx = allShipments.value.findIndex(s => s.id === data.id)
      if (idx !== -1) allShipments.value[idx] = { ...allShipments.value[idx], ...data }
    } else {
      const { data } = await axios.post('/admin/shipments', shipmentForm.value)
      allShipments.value.unshift(data)
    }
    showShipmentModal.value = false
  } catch (err) {
    shipmentFormError.value = err?.response?.data?.message || 'Failed to save shipment.'
  } finally {
    savingShipment.value = false
  }
}

// ── Messages ────────────────────────────────────────────────────
async function selectThread(thread) {
  selectedThread.value = thread
  const { data } = await axios.get(`/admin/sourcing-requests/${thread.id}/messages`)
  messages.value = data
  await nextTick()
  if (chatEl.value) chatEl.value.scrollTop = chatEl.value.scrollHeight
}

async function sendMessage() {
  if ((!newMessage.value.trim() && !adminChatFile.value) || !selectedThread.value) return
  let data
  if (adminChatFile.value) {
    const fd = new FormData()
    if (newMessage.value.trim()) fd.append('body', newMessage.value)
    fd.append('attachment', adminChatFile.value)
    const res = await axios.post(`/admin/sourcing-requests/${selectedThread.value.id}/messages`, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
    data = res.data
  } else {
    const res = await axios.post(`/admin/sourcing-requests/${selectedThread.value.id}/messages`, { body: newMessage.value })
    data = res.data
  }
  messages.value.push(data)
  newMessage.value = ''
  adminChatFile.value = null
  if (adminChatFileInput.value) adminChatFileInput.value.value = ''
  await nextTick()
  if (chatEl.value) chatEl.value.scrollTop = chatEl.value.scrollHeight
}

function isImage(mime) { return mime && mime.startsWith('image/') }

// ── Documents ────────────────────────────────────────────────────
function adminDocsBySection(section) {
  if (section === 'all') return allDocuments.value
  if (section === 'contract' || section === 'license') return allDocuments.value.filter(d => d.type === section)
  return allDocuments.value.filter(d => d.type !== 'contract' && d.type !== 'license')
}
function docTypeLabel(type) {
  return { contract: 'Contract', license: 'License', inspection_report: 'Inspection Report', invoice: 'Invoice', packing_list: 'Packing List / BoL', certificate_of_origin: 'Certificate of Origin', other: 'Other' }[type] || type
}
function fmtSize(bytes) {
  if (!bytes) return '—'
  if (bytes < 1000000) return (bytes / 1000).toFixed(0) + ' KB'
  return (bytes / 1000000).toFixed(1) + ' MB'
}
async function deleteAdminDoc(doc) {
  if (!confirm(`Delete "${doc.name}"?`)) return
  await axios.delete(`/admin/documents/${doc.id}`)
  allDocuments.value = allDocuments.value.filter(d => d.id !== doc.id)
}
async function submitAdminDocUpload() {
  if (!adminDocForm.file || !adminDocForm.sourcing_request_id) return
  adminDocUploadLoading.value = true
  adminDocUploadError.value   = null
  try {
    const fd = new FormData()
    fd.append('sourcing_request_id', adminDocForm.sourcing_request_id)
    const effectiveType = (adminDocForm.type === 'other' && adminDocForm.custom_type.trim()) ? adminDocForm.custom_type.trim() : adminDocForm.type
    fd.append('type', effectiveType)
    if (adminDocForm.name.trim()) fd.append('name', adminDocForm.name.trim())
    fd.append('file', adminDocForm.file)
    const { data } = await axios.post('/admin/documents', fd, { headers: { 'Content-Type': 'multipart/form-data' } })
    allDocuments.value.unshift(data)
    showAdminDocUpload.value = false
    Object.assign(adminDocForm, { sourcing_request_id: '', type: 'contract', custom_type: '', name: '', file: null })
  } catch (e) {
    adminDocUploadError.value = e?.response?.data?.message || 'Upload failed.'
  } finally {
    adminDocUploadLoading.value = false
  }
}

// ── User detail sub-component ───────────────────────────────────
const UserDetail = defineComponent({
  props: ['userId'],
  setup(props) {
    const detail = ref(null)
    onMounted(async () => {
      const { data } = await axios.get(`/admin/users/${props.userId}`)
      detail.value = data
    })
    return () => {
      if (!detail.value) return h('div', { class: 'text-xs text-gray-400 py-2' }, 'Loading…')
      const reqs = detail.value.sourcing_requests || []
      if (!reqs.length) return h('div', { class: 'text-xs text-gray-400 py-2' }, 'No sourcing requests yet.')
      return h('div', { class: 'space-y-2' },
        reqs.map(r => h('div', { class: 'flex items-center gap-3 text-xs' }, [
          h('span', { class: 'text-gray-600 font-medium truncate flex-1' }, r.title),
          h('span', { class: STATUS_COLORS[r.status] + ' px-2 py-0.5 rounded-full text-[10px] font-semibold' }, fmtStatus(r.status)),
          h('span', { class: 'text-gray-400' }, fmtDate(r.created_at)),
        ]))
      )
    }
  }
})

// ── Shipment helpers ────────────────────────────────────────────
function adminStepReached(status, step) {
  const order = ['pending', 'in_transit', 'customs', 'delivered']
  return order.indexOf(status) >= order.indexOf(step)
}

// ── Data loaders ────────────────────────────────────────────────
async function loadStats()     { const { data } = await axios.get('/admin/stats');                stats.value = data }
async function loadRequests()  { const { data } = await axios.get('/admin/sourcing-requests');    allRequests.value = data }
async function loadQuotes()    { const { data } = await axios.get('/admin/quotes');               allQuotes.value = data }
async function loadShipments() { const { data } = await axios.get('/admin/shipments');            allShipments.value = data }
async function loadThreads()   { const { data } = await axios.get('/admin/messages');             messageThreads.value = data }
async function loadDocuments() { const { data } = await axios.get('/admin/documents');            allDocuments.value = data }
async function loadUsers() {
  const { data } = await axios.get('/admin/users')
  allUsers.value = data.data || data
}

onMounted(() => {
  Promise.all([loadStats(), loadRequests(), loadQuotes(), loadShipments(), loadUsers(), loadThreads(), loadDocuments()])
})
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
