class QuickViewManager {
  constructor() {
    this.instance = null;
    this.isOpen = false;
  }
  
  static getInstance() {
    if (!QuickViewManager.instance) {
      QuickViewManager.instance = new QuickViewManager();
    }
    return QuickViewManager.instance;
  }
  
  open() {
    if (this.isOpen) return false;
    this.isOpen = true;
    document.body.style.overflow = 'hidden';
    return true;
  }
  
  close() {
    this.isOpen = false;
    document.body.style.overflow = '';
  }
  
  isQuickViewOpen() {
    return this.isOpen;
  }
}

export default QuickViewManager.getInstance();