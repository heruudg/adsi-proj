import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Activity, AlertTriangle, Package, Truck, Factory, ArrowUp, ArrowDown, Clock, Calendar } from 'lucide-react';
import { useEffect, useState } from 'react';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js';
import { Line, Bar, Doughnut } from 'react-chartjs-2';

// Register ChartJS components
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    // Mock data for the dashboard charts
    const [productionData, setProductionData] = useState({
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
            {
                label: 'Production Output',
                data: [1200, 1900, 3000, 5000, 2000, 3000],
                borderColor: 'rgb(53, 162, 235)',
                backgroundColor: 'rgba(53, 162, 235, 0.5)',
            },
            {
                label: 'Production Target',
                data: [2000, 2000, 3000, 4000, 4000, 5000],
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderDash: [5, 5],
            },
        ],
    });

    const [inventoryData, setInventoryData] = useState({
        labels: ['Raw A', 'Raw B', 'Raw C', 'Raw D', 'Raw E', 'Raw F'],
        datasets: [
            {
                label: 'Current Stock',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1,
            },
        ],
    });

    const [manufacturingOrders, setManufacturingOrders] = useState({
        labels: ['Pending', 'In Progress', 'Completed', 'Delayed'],
        datasets: [
            {
                label: 'Orders',
                data: [12, 19, 35, 5],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.6)', // Yellow - pending
                    'rgba(54, 162, 235, 0.6)', // Blue - in progress
                    'rgba(75, 192, 192, 0.6)', // Green - completed
                    'rgba(255, 99, 132, 0.6)', // Red - delayed
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1,
            },
        ],
    });
    
    const [workCenterMetrics, setWorkCenterMetrics] = useState({
        labels: ['Center A', 'Center B', 'Center C', 'Center D'],
        datasets: [
            {
                label: 'Utilization %',
                data: [85, 65, 92, 78],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
            },
            {
                label: 'Downtime %',
                data: [15, 35, 8, 22],
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
            },
        ],
    });

    // Summary statistics
    const summaryStats = [
        {
            title: "Total Production",
            value: "16,120 units",
            change: "+12.5%",
            icon: <Package className="h-5 w-5" />,
            trend: "up"
        },
        {
            title: "Active Orders",
            value: "31",
            change: "-5.2%",
            icon: <Activity className="h-5 w-5" />,
            trend: "down"
        },
        {
            title: "Avg. Production Time",
            value: "4.2 days",
            change: "-10.8%",
            icon: <Clock className="h-5 w-5" />,
            trend: "up"
        },
        {
            title: "On-time Delivery",
            value: "94.2%",
            change: "+2.7%",
            icon: <Truck className="h-5 w-5" />,
            trend: "up"
        },
    ];

    // Recent issues/alerts
    const recentIssues = [
        { id: 1, title: "Low inventory for Raw Material B", severity: "high", date: "Today" },
        { id: 2, title: "Work Center C maintenance required", severity: "medium", date: "Yesterday" },
        { id: 3, title: "Order #1234 deadline approaching", severity: "low", date: "2 days ago" },
        { id: 4, title: "Equipment calibration needed at Station 2", severity: "medium", date: "3 days ago" },
    ];

    // Upcoming schedule
    const upcomingSchedule = [
        { id: 1, title: "Start Order #5678 - Product X", time: "Today, 2:00 PM", workCenter: "Center A" },
        { id: 2, title: "Complete Order #1234", time: "Tomorrow, 10:00 AM", workCenter: "Center B" },
        { id: 3, title: "Maintenance - Center C", time: "Jul 20, 8:00 AM", workCenter: "Center C" },
        { id: 4, title: "Raw Material Delivery", time: "Jul 21, 9:00 AM", workCenter: "Warehouse" },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Summary Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {summaryStats.map((stat, index) => (
                        <Card key={index}>
                            <CardContent className="p-6">
                                <div className="flex justify-between items-center">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">{stat.title}</p>
                                        <h3 className="text-2xl font-bold mt-1">{stat.value}</h3>
                                    </div>
                                    <div className={`bg-gray-100 dark:bg-gray-800 p-3 rounded-full`}>
                                        {stat.icon}
                                    </div>
                                </div>
                                <div className="flex items-center mt-2">
                                    {stat.trend === "up" ? 
                                        <ArrowUp className="h-4 w-4 text-green-500 mr-1" /> : 
                                        <ArrowDown className="h-4 w-4 text-red-500 mr-1" />}
                                    <span className={stat.trend === "up" ? "text-green-500" : "text-red-500"}>
                                        {stat.change} from last month
                                    </span>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>
                
                {/* Charts Row */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {/* Production Trend Chart */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Production Output vs Target</CardTitle>
                            <CardDescription>Monthly production analysis</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[300px]">
                                <Line 
                                    data={productionData} 
                                    options={{
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                        },
                                    }}
                                />
                            </div>
                        </CardContent>
                    </Card>
                    
                    {/* Manufacturing Orders Status */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Manufacturing Orders Status</CardTitle>
                            <CardDescription>Current order status distribution</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[300px] flex justify-center">
                                <div className="w-[280px]">
                                    <Doughnut 
                                        data={manufacturingOrders} 
                                        options={{
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    position: 'right',
                                                },
                                            },
                                        }}
                                    />
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
                
                {/* Second Row of Charts */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {/* Work Center Performance */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Work Center Performance</CardTitle>
                            <CardDescription>Utilization and downtime metrics</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[300px]">
                                <Bar 
                                    data={workCenterMetrics} 
                                    options={{
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                max: 100,
                                                title: {
                                                    display: true,
                                                    text: 'Percentage (%)'
                                                }
                                            }
                                        }
                                    }}
                                />
                            </div>
                        </CardContent>
                    </Card>
                    
                    {/* Inventory Levels */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Raw Material Inventory</CardTitle>
                            <CardDescription>Current stock levels</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[300px]">
                                <Bar 
                                    data={inventoryData} 
                                    options={{
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                        },
                                    }}
                                />
                            </div>
                        </CardContent>
                    </Card>
                </div>
                
                {/* Third Row - Issues and Schedule */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {/* Recent Issues */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <AlertTriangle className="h-5 w-5" />
                                <span>Recent Issues</span>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentIssues.map((issue) => (
                                    <div key={issue.id} className="flex items-start gap-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <div className={`rounded-full p-1 mt-1 ${
                                            issue.severity === 'high' ? 'bg-red-100 text-red-600' :
                                            issue.severity === 'medium' ? 'bg-amber-100 text-amber-600' :
                                            'bg-blue-100 text-blue-600'
                                        }`}>
                                            <AlertTriangle className="h-4 w-4" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium">{issue.title}</p>
                                            <div className="flex justify-between items-center mt-1">
                                                <span className={`text-xs px-2 py-1 rounded-full ${
                                                    issue.severity === 'high' ? 'bg-red-100 text-red-700' :
                                                    issue.severity === 'medium' ? 'bg-amber-100 text-amber-700' :
                                                    'bg-blue-100 text-blue-700'
                                                }`}>
                                                    {issue.severity}
                                                </span>
                                                <span className="text-xs text-gray-500">{issue.date}</span>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                    
                    {/* Upcoming Schedule */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <Calendar className="h-5 w-5" />
                                <span>Upcoming Schedule</span>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {upcomingSchedule.map((item) => (
                                    <div key={item.id} className="flex items-start gap-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <div className="rounded-full p-1 mt-1 bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            <Clock className="h-4 w-4" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium">{item.title}</p>
                                            <div className="flex justify-between items-center mt-1">
                                                <span className="text-xs">{item.time}</span>
                                                <span className="text-xs px-2 py-1 bg-gray-100 rounded-full dark:bg-gray-800">
                                                    {item.workCenter}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
