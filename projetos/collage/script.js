/*****************************************************************************
 * @FilePath              : polaroids/script.js                              *
 ****************************************************************************/

let selectedModel = 'model1'; // Default model

// Choose collage model
function chooseModel(model) {
  selectedModel = model;
  document.querySelectorAll('.collage-models img').forEach(img => img.classList.remove('selected'));
  document.querySelector(`img[alt='${model}']`).classList.add('selected');
  arrangeCollage();
}

// Handle drag and drop
function handleDragOver(event) {
  event.preventDefault();
}

function handleDrop(event) {
  event.preventDefault();
  const files = event.dataTransfer.files;
  handleFiles(files);
}

// Handle file upload input
function handleFileUpload(event) {
  const files = event.target.files;
  handleFiles(files);
}

// Handle files and create image elements
function handleFiles(files) {
  const container = document.getElementById('collageContainer');
  Array.from(files).forEach(file => {
    if (file.type.startsWith('image/')) {
      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.ondblclick = () => downloadImage(img.src); // Download on double-click
      container.appendChild(img);
    }
  });
  arrangeCollage();
}

// Arrange images according to selected model
function arrangeCollage() {
  const container = document.getElementById('collageContainer');
  // Clear existing images if needed
  // Apply layout based on selectedModel (additional logic can be added for each model)
  // Placeholder logic for model-specific arrangements:
  if (selectedModel === 'model1') {
    container.style.flexDirection = 'row';
  } else if (selectedModel === 'model2') {
    container.style.flexDirection = 'column';
  }
  // Add logic for additional models here...
}

// Download individual image on double-click
function downloadImage(src) {
  const link = document.createElement('a');
  link.href = src;
  link.download = 'polaroid-image.png';
  link.click();
}

// Download entire collage as a single image
function downloadCollage() {
  html2canvas(document.getElementById('collageContainer')).then(canvas => {
    const link = document.createElement('a');
    link.href = canvas.toDataURL();
    link.download = 'collage.png';
    link.click();
  });
}
