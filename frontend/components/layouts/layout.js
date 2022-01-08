export const Layout = ({ children }) =>
  <div className="bg-gray-100 min-h-screen py-8 space-y-4 px-2">
    <h1 className="text-center font-bold text-4xl my-4 text-blue-800">To Do List</h1>
    {children}
  </div>