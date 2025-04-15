<!-- Header Galeri -->
<div>
  <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
      <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white px-4">
              <h1 class="text-4xl md:text-5xl font-bold mb-2">GALERI</h1>
              <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
          </div>
      </div>
  </div>

  <!-- Gallery Section -->
  <div class="max-w-5xl mx-auto mt-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Gambar 1 -->
      <div class="bg-white p-2 rounded-lg shadow hover:scale-105 transition-transform duration-300 cursor-pointer" onclick="showModal('https://via.placeholder.com/800x500.png?text=Gambar+1')">
        <img 
          src="https://via.placeholder.com/300x200.png?text=Gambar+1"
          alt="Gambar 1"
          class="w-full h-auto rounded-lg object-cover"
        />
      </div>

      <!-- Placeholder Box -->
      @for($i = 2; $i <= 6; $i++)
        <div class="bg-gray-300 rounded-lg h-[200px] hover:opacity-75 transition duration-300"></div>
      @endfor

    </div>
  </div>

  <!-- Modal -->
  <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-3xl w-full relative">
      <button class="absolute top-2 right-2 text-black text-xl" onclick="hideModal()">✕</button>
      <img id="modalImage" src="" class="w-full h-auto object-contain" />
    </div>
  </div>
</div>
