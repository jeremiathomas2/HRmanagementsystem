// Icon Helper for Blade Templates
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
  const iconClass = window.Icons[iconName];
  if (!iconClass) {
    console.warn(`Icon "${iconName}" not found`);
    return '';
  }
  
  return iconClass.render({
    class: className
  });
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  // Replace all icon placeholders
  const iconElements = document.querySelectorAll('[data-icon]');
  iconElements.forEach(element => {
    const iconName = element.getAttribute('data-icon');
    const className = element.getAttribute('class') || 'h-5 w-5';
    element.innerHTML = window.renderIcon(iconName, className);
  });
});
