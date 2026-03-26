// Icon Helper for Blade Templates
import './icon-fallbacks';
import { 
    Home, 
    Users, 
    CreditCard, 
    AlertTriangle,
    Calendar,
    Briefcase,
  BarChart,
  GraduationCap,
  Settings,
  Bell,
  Menu,
  X,
  CheckCircle,
  XCircle,
  Info,
  ChevronRight,
  User,
  Building,
  FileText,
  ClipboardList,
  Banknote,
  Shield,
  Clock,
  UserCircle,
  TrendingUp,
  BookOpen,
  Presentation
} from 'lucide';

// Export icons for use in Blade templates
window.Icons = {
  // Navigation Icons
  home: Home,
  users: Users,
  payroll: CreditCard,
  discipline: AlertTriangle,
  leave: Calendar,
  recruitment: Briefcase,
  performance: BarChart,
  training: GraduationCap,
  settings: Settings,
  notifications: Bell,
  menu: Menu,
  close: X,
  
  // Status Icons
  success: CheckCircle,
  error: XCircle,
  info: Info,
  warning: AlertTriangle,
  
  // Action Icons
  arrowRight: ChevronRight,
  user: User,
  building: Building,
  document: FileText,
  list: ClipboardList,
  money: Banknote,
  shield: Shield,
  clock: Clock,
  userCircle: UserCircle,
  trending: TrendingUp,
  book: BookOpen,
  chart: Presentation
};

// Helper function to render icon
window.renderIcon = function(iconName, className = 'h-5 w-5') {
  // Use fallback directly for now
  const fallback = window.IconFallbacks[iconName];
  if (fallback) {
    return fallback.replace('class="h-5 w-5"', `class="${className}"`);
  }
  
  // Default fallback
  return `<svg class="${className}" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6h6m-9 12l2 2m0 0l2-2m-2 2l2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>`;
};

// Manual icon rendering function
window.renderAllIcons = function() {
  const iconElements = document.querySelectorAll('[data-icon]');
  console.log(`Rendering ${iconElements.length} icons`);
  
  iconElements.forEach((element, index) => {
    const iconName = element.getAttribute('data-icon');
    const className = element.getAttribute('class') || 'h-5 w-5';
    
    try {
      const svgContent = window.renderIcon(iconName, className);
      element.innerHTML = svgContent;
      
      // Ensure the SVG is visible
      const svg = element.querySelector('svg');
      if (svg) {
        svg.style.display = 'inline-block';
        svg.style.verticalAlign = 'middle';
        svg.style.width = '1em';
        svg.style.height = '1em';
      }
      
      console.log(`Icon ${index + 1}/${iconElements.length}: ${iconName} rendered`);
    } catch (error) {
      console.error(`Failed to render icon ${iconName}:`, error);
    }
  });
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing icons...');
  setTimeout(window.renderAllIcons, 100);
});

// Also initialize when window is fully loaded
window.addEventListener('load', function() {
  console.log('Window loaded, checking icons...');
  setTimeout(window.renderAllIcons, 200);
});

// Make function globally available for manual testing
window.testIcons = function() {
  console.log('Testing icon rendering...');
  window.renderAllIcons();
};
