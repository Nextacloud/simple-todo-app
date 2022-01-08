export const usePagination = (taskPage, setTaskPage, lastPage) => {

  const onClickPrev = () => {
    if (taskPage <= 1) return;

    const updatedTaskPage = taskPage - 1;

    setTaskPage(updatedTaskPage);
  }

  const onClickNext = () => {
    if (taskPage >= lastPage) return;

    const updatedTaskPage = taskPage + 1;

    setTaskPage(updatedTaskPage);
  }

  return {onClickPrev, onClickNext}
}
